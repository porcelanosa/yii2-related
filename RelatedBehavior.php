<?php
	namespace porcelanosa\yii2related;
	
	
	use Yii;
	use yii\behaviors\AttributeBehavior;
	use porcelanosa\yii2related\models\RelatedObjects;
	use yii\db\ActiveRecord;
	use yii\helpers\ArrayHelper;
	use yii\base\InvalidConfigException;
	
	/**
	 *
	 **/
	class RelatedBehavior
		extends AttributeBehavior {
		
		public $model_name = '';
		public $model_id_field_name = 'id';
		public $model_name_field_name = 'name';
		public $post_name = 'related_objects';
		
		public function events() {
			return [
				ActiveRecord::EVENT_BEFORE_UPDATE => 'saveRelated',
			];
		}
		
		public function saveRelated() {
			
			$model = $this->owner;
			if ( ! isset( $this->model_name ) || $this->model_name == '' ) {
				throw new InvalidConfigException( "The 'model_name' option is required. For example, 'Items'" );
			}
			$related_objects = Yii::$app->getRequest()->post( $this->post_name );
			$old_related     = RelatedObjects::find()->where(
				[
					'model'    => $this->modelFromNamespace( $this->model_name ),
					'model_id' => $model->id
				]
			)->all()
			;
			/**
			 * Удаляем все связанные модели
			 * */
			foreach ( $old_related as $old_model ) {
				$old_model->delete();
			}
			/**
			 * Добавляем новые связанные модели
			 */
			if ( $related_objects AND is_array( $related_objects ) AND count( $related_objects ) > 0 ) {
				foreach ( $related_objects as $id ) {
					$related             = new RelatedObjects;
					$related->model      = $this->modelFromNamespace( $this->model_name );
					$related->model_id   = $model->id;
					$related->related_id = $id;
					$related->save();
				}
			}
			
		}
		
		public function getRelated() {
			$model = $this->owner;
			if ( ! isset( $this->model_name ) || $this->model_name == '' ) {
				throw new InvalidConfigException( "The 'model_name' option is required. For example, 'Items'" );
			}
			$related_ids = RelatedObjects::find()->select( 'related_id' )->where(
				[
					'model'    => $this->modelFromNamespace( $this->model_name ),
					'model_id' => $model->id
				]
			)->orderBy( 'sort' )->asArray()->all()
			;
			
			/**
			 * @var $m ActiveRecord
			 */
			$m = new $this->model_name();
			
			return $m::find()->where(
				[
					'IN',
					$this->model_id_field_name,
					$this->flatArray( $related_ids, 'related_id' )
				]
			)->all()
				;
			
			//$m;
		}
		
		public function getRelatedAsArray() {
			$model = $this->owner;
			if ( ! isset( $this->model_name ) || $this->model_name == '' ) {
				throw new InvalidConfigException( "The 'model_name' option is required. For example, 'Items'" );
			}
			$related_ids = RelatedObjects::find()->select( 'related_id' )->where(
				[
					'model'    => $this->modelFromNamespace( $this->model_name ),
					'model_id' => $model->id
				]
			)->orderBy( 'sort' )->asArray()->all()
			;
			
			/**
			 * @var $m ActiveRecord
			 */
			$m = new $this->model_name();
			
			$related = $m::find()->select( [ 'id', 'name' ] )->where(
				[
					'IN',
					$this->model_id_field_name,
					$this->flatArray( $related_ids, 'related_id' )
				]
			)->asArray()->all()
			;
			
			return $this->flatArray2( $related, $this->model_id_field_name, $this->model_name_field_name );
		}
		
		public function getAllAsArray() {
			$model = $this->owner;
			if ( ! isset( $this->model_name ) || $this->model_name == '' ) {
				throw new InvalidConfigException( "The 'model_name' option is required. For example, 'Items'" );
			}
			/**
			 * @var $m ActiveRecord
			 */
			$m = new $this->model_name();
			
			$all = $m::find()->select( [ 'id', 'name' ] )->asArray()->all();
			
			return $this->flatArray2( $all, 'id', 'name' );
		}
		
		public function getRelatedIdsArray() {
			$model = $this->owner;
			if ( ! isset( $this->model_name ) || $this->model_name == '' ) {
				throw new InvalidConfigException( "The 'model_name' option is required. For example, 'Items'" );
			}
			$related_ids = RelatedObjects::find()->select( 'related_id' )->where(
				[
					'model'    => $this->modelFromNamespace( $this->model_name ),
					'model_id' => $model->id
				]
			)->orderBy( 'sort' )->asArray()->all()
			;
			
			/**
			 * @var $m ActiveRecord
			 */
			$m = new $this->model_name();
			
			$related = $m::find()->select( [ 'id', 'name' ] )->where(
				[
					'IN',
					$this->model_id_field_name,
					$this->flatArray( $related_ids, 'related_id' )
				]
			)->asArray()->all()
			;
			
			return $this->flatArray3( $related, $this->model_id_field_name );
		}
		
		/**
		 * Return flat array from ActiveRecord asArray()
		 *
		 * @param $arr        array
		 * @param $value_name string
		 *
		 * @return array
		 */
		public function flatArray( $arr, $value_name ) {
			$r_arr = [ ];
			foreach ( $arr as $key => $value ) {
				$r_arr[] = $value[ $value_name ];
			}
			
			return $r_arr;
		}
		
		/**
		 * Return flat array from ActiveRecord asArray()
		 *
		 * @param $arr        array
		 * @param $value_name string
		 *
		 * @return array
		 */
		public function flatArray2( $arr, $value_id, $value_name ) {
			$r_arr = [ ];
			foreach ( $arr as $key => $value ) {
				$r_arr[ $value[ $value_id ] ] = $value[ $value_name ];
			}
			
			return $r_arr;
		}
		
		/**
		 * Return flat array from ActiveRecord asArray()
		 *
		 * @param $arr        array
		 * @param $value_name string
		 *
		 * @return array
		 */
		public function flatArray3( $arr, $value_id ) {
			$r_arr = [ ];
			foreach ( $arr as $value ) {
				$r_arr[] = $value[ $value_id ];
			}
			
			return $r_arr;
		}
		
		/**
		 * Return model class without namespace
		 *
		 * @param $namespace string
		 *
		 * @return string
		 */
		
		public static function modelFromNamespace( $namespace ) {
			$pattern = '/.+\\\/i';
			
			return preg_replace( $pattern, '', $namespace );
		}
	}