<?php
/*
 Plugin Name: Conversion Tracking for WooCommerce
 Plugin URI: https://marketacumen.com/?crcat=wp-plugin&crsource=conversion-tracking-for-woocommerce&crcpn=plugin&crkw=plugin-uri
 Description: Outputs JavaScript variables for various steps in your order process, making it very easy to integrate with most analytics packages.
 Version: 1.0
 Author: Kent Davidson
 Author URI: https://marketacumen.com/?crcat=wp-plugin&crsource=conversion-tracking-for-woocommerce&crcpn=plugin&crkw=author-uri
 License: GPL2
 WC requires at least: 2.3
 WC tested up to: 3.2.6
 */

/* Do not directly invoke this page */
if (!defined('ABSPATH')) {
	die("Nope");
}

/* @var Closure add_action */

/**
 * Main singleton class
 *
 * @author kent
 * @copyright &copy; 2018 Market Acumen, Inc.
 */
class WooCommerce_JavaScript_Output {
	/**
	 *
	 * @var self
	 */
	static $singleton = null;

	/**
	 *
	 * @return self
	 */
	public static function singleton() {
		if (self::$singleton === null) {
			self::$singleton = new self();
		}
		return self::$singleton;
	}

	/**
	 *
	 */
	public function __construct() {
		$this->initialize_hooks();
	}

	/**
	 * Connect into WooCommerce
	 */
	private function initialize_hooks() {
		add_action('woocommerce_thankyou', array(
			$this,
			'action_order_confirmation'
		));
		add_action('woocommerce_after_cart_contents', array(
			$this,
			'action_after_cart_contents'
		));
		add_action('woocommerce_after_checkout_form', array(
			$this,
			'action_after_checkout_form'
		));
	}

	/**
	 *
	 * @param unknown $order_id
	 * @return unknown|mixed
	 */
	public function action_order_confirmation($order_id) {
		$this->action_order_json($order_id, "order-confirmation");
	}

	/**
	 *
	 */
	public function action_after_cart_contents() {
		$this->cart_to_json("cart");
	}

	/**
	 *
	 */
	public function action_after_checkout_form() {
		$this->cart_to_json("checkout");
	}

	/**
	 * Output cart details
	 *
	 * @param string $type
	 */
	private function cart_to_json($type) {
		/*
		 * $cart->get_total() returns the display total. Use ->get_total(null) to get the total.
		 * This is called after the cart is displayed so totals should all be calculated.
		 */
		$cart = WC()->cart;
		/* @var $cart WC_Cart */
		$json_items = $this->cart_items_to_json($cart->get_cart());
		$json_cart = array(
			"is_empty" => $cart->is_empty(),
			"coupons" => $cart->get_applied_coupons(),
			"subtotal" => doubleval($cart->get_subtotal()),
			"total" => doubleval($cart->get_total(null)),
			"shipping" => doubleval($cart->get_shipping_total()),
			"taxes" => doubleval($cart->get_taxes()),
			"currency" => get_woocommerce_currency(),
			"items" => $json_items
		);
		$json = array(
			"type" => $type,
			"cart" => $json_cart,
			"customer" => $this->customer_to_json($cart->get_customer())
		);
		$this->output_payload($json);
	}
	/**
	 * Convert cart items to JSON
	 *
	 * @param array $items
	 * @return number[]
	 */
	private function cart_items_to_json(array $items) {
		$json_items = array();
		foreach ($items as $key => $item) {
			$json_items[] = $this->product_to_json($item['data']) + array(
				"id" => $item['product_id'],
				"variation_id" => $item['variation_id'],
				"quantity" => $item['quantity'],
				"price" => doubleval($item['line_subtotal']),
				"tax" => doubleval($item['line_tax']),
				"total" => doubleval($item['line_total'])
			);
		}
		return $json_items;
	}

	/**
	 * @param WC_Order_Item[] $items
	 * @return array[]
	 */
	private function order_items_to_json($items) {
		$json_items = array();
		if (!is_iterable($items)) {
			return $json_items;
		}
		foreach ($items as $item) {
			/* @var $item WC_Cart_Item */
			$product = self::fetch_from_object($item, array(
				'get_product'
			));
			$json_product = $this->product_to_json($product);
			$json_items[] = $json_product + array(
				'id' => $item->get_id(),
				'name' => $item->get_name(),
				'quantity' => $item->get_quantity(),
				'variation_id' => self::fetch_from_object($item, array(
					'get_variation_id'
				)),
				'subtotal' => doubleval(self::fetch_from_object($item, array(
					"get_subtotal"
				))),
				'total' => doubleval(self::fetch_from_object($item, array(
					"get_total"
				))),
				'tax' => doubleval(self::fetch_from_object($item, array(
					"get_taxes"
				)))
			);
		}
		return $json_items;
	}

	/**
	 *
	 * @param WC_Order $order
	 */
	private function order_json($order) {
		return array(
			'order' => array(
				'id' => $order->get_order_number(),
				'total' => doubleval($order->get_total(null)),
				'subtotal' => doubleval($order->get_subtotal()),
				'shipping' => doubleval($order->get_shipping_total()),
				'taxes' => doubleval($order->get_total_tax(null)),
				'coupons' => $order->get_used_coupons(),
				'items' => $this->order_items_to_json($order->get_items())
			),
			'payment' => array(
				'currency' => self::fetch_from_object($order, array(
					'get_currency',
					'get_order_currency'
				)),
				'method' => self::fetch_from_object($order, array(
					'get_payment_method',
					'.payment_method'
				))
			),
			'customer' => $this->customer_to_json($order->get_user())
		);
	}

	/**
	 * Convert WC_Product into JSON
	 *
	 * @param WC_Product $product
	 * @return array
	 */
	private function product_to_json($product) {
		if (!$product || !is_a($product, 'WC_Product')) {
			return array();
		}
		return array(
			'id' => $product->get_id(),
			'name' => $product->get_name(),
			'link' => $product->get_permalink(),
			'description' => $product->get_description(),
			'price' => doubleval($product->get_price())
		);
	}

	/**
	 *
	 * @param mixed $customer
	 * @return array|null
	 */
	private function customer_to_json($customer) {
		if (!$customer) {
			return null;
		}
		$id = self::fetch_from_object($customer, array(
			"get_id",
			".ID"
		));
		if (!$id) {
			return new stdClass();
		}
		return array(
			'id' => $id,
			'email' => self::fetch_from_object($customer, array(
				"get_email",
				".user_email"
			)),
			'name_first' => self::fetch_from_object($customer, array(
				"get_first_name",
				".first_name"
			)),
			'name_last' => self::fetch_from_object($customer, array(
				"get_last_name",
				".last_name"
			))
		);
	}

	/**
	 *
	 * @param mixed $order_id
	 * @return unknown|mixed
	 */
	private function action_order_json($order_id, $type) {
		if (is_a($order_id, 'WC_Order')) {
			$order = $order_id;
		} else {
			$order = wc_get_order($order_id);
		}
		// Is it a WC_Order? If not, output an error
		if (!is_a($order, 'WC_Order')) {
			$json = array(
				"type" => "error",
				"actual_type" => $type,
				"message" => "$order_id did not load WC_Order",
				"error_type" => gettype($order)
			);
		} else {
			$json = $this->order_json($order) + array(
				"type" => $type
			);
		}
		$this->output_payload($json);
	}

	/**
	 *
	 * @param mixed $json
	 */
	private function output_payload($json, $variable = "WCPAYLOAD") {
		$me = basename(__FILE__, ".php");
		$javascript = "/* $me */\n(function (w) {\nw.$variable = " . json_encode($json, JSON_PRETTY_PRINT) . ";\n}(window));\n";
		$tag = "<script>\n$javascript</script>";
		echo $tag;
	}

	/**
	 * Handle compatibility by using method_exists or member accessors instead of explict version numbers.
	 *
	 * @param object $object
	 * @param array $methods
	 * @param mixed $default
	 * @return mixed
	 */
	private static function fetch_from_object($object, array $methods, $default = null) {
		foreach ($methods as $method) {
			if (substr($method, 0, 1) === '.') {
				$member = substr($method, 1);
				if ($object->$member) {
					return $object->$member;
				}
				continue;
			}
			if (method_exists($object, $method)) {
				return $object->$method();
			}
		}
		return $default;
	}
}

WooCommerce_JavaScript_Output::singleton();
