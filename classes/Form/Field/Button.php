<?php

class DND_Form_Field_Button extends DND_Form_Field_Field {


	protected $icon    = '';
	protected $onclick = '';
	protected $text    = 'Button Text';
	protected $tag     = 'button';
	protected $type    = 'button';


public function button($echo=true,$id='') {
    $html = "<button";
    $html.= (empty($id)) ? "" : " id='$id'";
    $html.= " class='btn {$this->css}'";
    $html.= $this->form_tooltip();
    $html.= (isset($this->click)) ? " onclick='{$this->click}'" : '' ;
    $html.= (isset($this->tab))   ? " tabindex={$this->tab}" : '';
    $html.= (isset($this->icon))  ? "><i class='{$this->icon}'></i> " : ">";
    $html.= "{$this->text}</button>";
    if ($echo) { echo $html; } else { return $html; }
  }

	public function button() {
		echo $this->get_button();
	}

	public function get_button() {
		$html = $this->get_input_tag();
#		if 
	}

	protected function get_input_attributes() {
		$attrs = parent::get_input_attributes();
		$attrs['onclick'] = $this->onclick;
		return $attrs;
	}

	protected function add_form_control_css( $new = '' ) {
		parent::add_form_control_css( 'btn' );
	}


}
