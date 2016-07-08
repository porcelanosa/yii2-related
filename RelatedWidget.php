<?php
	namespace porcelanosa\yii2related;
	
	use yii\base\Widget;
	use yii\db\ActiveRecord;
	
	/**
	 * Widget to Related Behavior
	 *
	 * @author Porcelanosa
	 */
	class RelatedWidget extends Widget {
		/** @var ActiveRecord */
		public $model;
		public $model_name = '';
		
		/** @var string */
		public $behaviorName;
		
		/** @var RelatedBehavior Model of gallery to manage */
		protected $behavior;
		
		public $options = array();
		
		public $title = '';
		public $placeholder = 'Выберите похожие ...';
		
		public function init() {
			parent::init();
			$this->behavior = $this->model->getBehavior( $this->behaviorName );
		}
		
		/** Render widget */
		public function run() {
			
			$m = new $this->model_name();
			$data = $m->allAsArray;
			// Without model and implementing a multiple select
			if($this->title != '') {
				echo '<label class="control-label">'.$this->title.'</label>';
			}
			echo \kartik\select2\Select2::widget(
				[
					'name'    => $this->behavior->post_name,
					'data'    => $data,
					'value'   => $this->model->relatedIdsArray,
					'options' => [
						'placeholder' => $this->placeholder,
						'multiple'    => true,
						'sorter'=> 'function(data) {
									return data.sort();
								}'
					],
				]
			);
		}
	}
	
	?>