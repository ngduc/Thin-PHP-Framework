<?php
require_once('templates/class/Connection.class.php');
require_once('templates/class/ConnectionFactory.class.php');
require_once('templates/class/QueryExecutor.class.php');
require_once('templates/class/Transaction.class.php');
require_once('templates/class/SqlQuery.class.php');
require_once('templates/class/Template.php');

function generate()
{
	@mkdir("generated");
	
	$sql = 'SHOW TABLES';
	$ret = QueryExecutor::execute(new SqlQuery($sql));
	generateDomainObjects($ret);
}

function doesTableContainPK($row){
	$row = getFields($row[0]);
	for($j=0;$j<count($row);$j++){
		if($row[$j][3]=='PRI'){
			return true;
		}
	}
	return false;
}

/**
 * Enter description here...
 *
 * @param unknown_type $ret
 * @return
 */
function generateDomainObjects($ret){
	for($i=0;$i<count($ret);$i++){
		if(!doesTableContainPK($ret[$i])){
			continue;
		}
		$tableName = $ret[$i][0];
		$clazzName = getClazzName($tableName);
		if($clazzName[strlen($clazzName)-1]=='s'){
			$clazzName = substr($clazzName, 0, strlen($clazzName)-1);
		}
		$template = new Template('templates/Domain.tpl');
		$template->set('domain_class_name', $clazzName);
		$template->set('table_name', $tableName);
		$tab = getFields($tableName);
		$fields = "";
		
		$initFields = "";
		$getsetMethods = "\n";
		$toStrFields = "return ''";
		for($j=0;$j<count($tab);$j++) {
			$fieldName = getVarNameWithS($tab[$j][0]);
			$fields .= "\tprivate $".$fieldName.";\n";
			
			$initFields .= "\t\t\$this->".$fieldName." = \$fields['".$fieldName."'];\n";
			
			$camelFieldName = $fieldName;
			$camelFieldName[0] = strtoupper($fieldName[0]);
			$getsetMethods .= "\tpublic function get$camelFieldName() {\n\t\treturn \$this->".$fieldName.";\n\t}\n";
			$getsetMethods .= "\tpublic function set$camelFieldName($".$fieldName.") {\n\t\t\$this->".$fieldName." = $".$fieldName.";\n\t}\n\n";
			$toStrFields .= ".':'.\$this->".$fieldName;
		}
		$toStrFields .= ";";
		
		$template->set('variables', $fields);
		$template->set('init_variables', $initFields);
		$template->set('getset_methods', $getsetMethods);
		$template->set('tostr_variables', $toStrFields);
		
		$template->set('date', date("Y-m-d H:i"));
		$template->write('generated/'.$clazzName.'.php');
	}
}


function isColumnTypeNumber($columnType){
	echo $columnType.'<br/>';
	if(strtolower(substr($columnType,0,3))=='int' || strtolower(substr($columnType,0,7))=='tinyint'){
		return true;
	}
	return false;
}

function getFields($table){
	$sql = 'DESC '.$table;
	return QueryExecutor::execute(new SqlQuery($sql));
}


function getClazzName($tableName){
	$tableName = strtoupper($tableName[0]).substr($tableName,1);
	for($i=0;$i<strlen($tableName);$i++){
		if($tableName[$i]=='_'){
			$tableName = substr($tableName, 0, $i).strtoupper($tableName[$i+1]).substr($tableName, $i+2);
		}
	}
	return $tableName;
}

function getDTOName($tableName){
	$name = getClazzName($tableName);
	if($name[strlen($name)-1]=='s'){
		$name = substr($name, 0, strlen($name)-1);
	}
	return $name;
}

function getVarName($tableName){
	$tableName = strtolower($tableName[0]).substr($tableName,1);
	for($i=0;$i<strlen($tableName);$i++){
		if($tableName[$i]=='_'){
			$tableName = substr($tableName, 0, $i).strtoupper($tableName[$i+1]).substr($tableName, $i+2);
		}
	}
	if($tableName[strlen($tableName)-1]=='s'){
		$tableName = substr($tableName, 0, strlen($tableName)-1);
	}
	return $tableName;
}


function getVarNameWithS($tableName){
	$tableName = strtolower($tableName[0]).substr($tableName,1);
	for($i=0;$i<strlen($tableName);$i++){
		if($tableName[$i]=='_'){
			$tableName = substr($tableName, 0, $i).strtoupper($tableName[$i+1]).substr($tableName, $i+2);
		}
	}	
	return $tableName;
}

generate();
