<?php       			
    $page_name = str_replace("_", " ", substr($model->tableName(), 4));
    $menu_path['admin'] = 'DevMenuItem/admin';   
    $menu_path['create'] = 'DevMenuItem/create';   
    $results = $data;  
    
    
/**
 *
 * O array "fk_field" permite escolher qual campo estrangeiro relacionado deve ser exibido.
 */
			
	$fk_field['id_menu_filho'] = 'nome';
			
	$fk_field['id_menu_pai'] = 'nome';
	
	foreach ($results as $id_result=>$result){
		foreach ($result->relations() as $nome_rel=>$relation){
			if(isset($result->{$relation[2]})&&$result->{$relation[2]}!=0)
				$result->{$relation[2]} = $data[$id_result]->{$nome_rel}->{$fk_field[$relation[2]]};
		}
		$results[$id_result] = $result;
	}
	
	
/**
 *
 * O array "field_pai" permite escolher qual campo estrangeiro deve ser mostrado no DropDownList.
 */	
			
	$field_pai['dev_menu_fk_id_menu_filho'] = 'id';
			
	$field_pai['dev_menu_fk_id_menu_pai'] = 'id';
		
	foreach ($DropDownList as $key=>$fdata){
		$fdata = $fdata['fdata'];
		$fTable = $DropDownList[$key]['fTable'];
		$DropDownListData = $DropDownList[$key]['fdataId'];
				
		foreach ($DropDownListData as $k=>$item){
			foreach ($fdata as $a=>$f){
				if($f->{$fdata[0]->tableSchema->primaryKey} == $item){
					$DropDownListData[$item] = $f->{$field_pai[$fdata[0]->tableSchema->name.'_fk_'.$key]};					
				}
			}			
		}
		$ObjDropDownList[$key] = $DropDownListData;
	} 
	
?>

<?php
/* @var $this DevMenuItemController */
/* @var $model DevMenuItem */

$this->breadcrumbs=array(
	'Dev Menu Items'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

?>

					<!-- start page title -->
                	<div class="page-title" >
                		<div class="in">
                    		<div class="titlebar">	<h2><?php  echo strtoupper($page_name); ?></h2>	<p>Gerenciamento de <?php  echo strtolower($page_name); ?>.</p></div>
                            <?php  $this->renderPartial('../layouts/menu_crud_completo',array('menu_path'=>$menu_path));?>
                            <div class="clear"></div>
                    	</div>
                	</div>
                	<!-- end page title -->

<?php $this->renderPartial('_form', array('model'=>$model,'label_colunas'=>$label_colunas,'DropDownListData'=>$ObjDropDownList)); ?>