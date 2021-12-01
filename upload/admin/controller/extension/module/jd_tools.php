<?php
class ControllerExtensionModuleJDTools extends Controller {
	private $code = "module_jd_tools";
	private $module_name = "jd_tools";
	public function index() {
		// jd todo write jd_tools setting index();
		$this->response->redirect(
			$this->url->link('marketplace/extension', ['user_token' => $this->request->get['user_token'], 'type' => 'module'])
		);
	}

	public function install() {
		// multistore support
		$store_id = isset($this->request->get['config_store_id'])? $this->request->get['config_store_id']
				: (int)$this->config->get('config_store_id');

		// required settings (stored in db)
		$required = [
			$this->code . '_status' => $this->config->get($this->code . '_status'),
			$this->code . '_menu_items' =>  $this->config->get($this->code . '_menu_items'),
		];

		/*
		 * load from files system/config/jd_tools.php,
		 * system/config/jd_tools_custom.php(if kotygor/opencart_3x_fixes),
		 * include events and ocmods
		 * */
		$this->load->config($this->module_name);

		foreach ($required as $key => &$value) {
			if(is_null($value)) {
				$value = $this->config->get($key); // now it includes default values from system/config/$module_name
				if(is_null($value)) $this->log->write("admin_extension_module_jd_tools: required setting not exists! key = " . $key);
			}
		}

		$this->load->model('setting/setting');
			$this->model_setting_setting->editSetting(
				$this->code,
				$required,
				$store_id
			);
		}
	public function uninstall() {

	}

	public function addItemExample() {
		$this->load->model('extension/module/jd_tools');
		$item = [
			'route'  => 'customer/customer',
			'name'  =>  'Customers',
			'children'  =>  [],
			'sort_order'    =>  10,
		];
		$this->model_extension_module_jd_tools->addMenuItem('custom_name', $item);
	}
}