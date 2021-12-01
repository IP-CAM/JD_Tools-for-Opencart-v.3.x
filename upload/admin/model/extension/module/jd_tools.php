<?php
class ModelExtensionModuleJDTools extends Model {
	private $code = 'module_jd_tools';
	private $menu_key = 'module_jd_tools_menu_items';

	public function addMenuItem($name, $data, $store_id = 0) {

		$this->load->model('setting/setting');
		$stored_items = json_decode(
			$this->model_setting_setting->getSettingValue($this->menu_key, $store_id),
		1);

		// jd todo write jd_tools::addMenuItem();
		$stored_items[$name] = $data;
		$this->model_setting_setting->editSettingValue($this->code, $this->menu_key, $stored_items, $store_id);

	}
}