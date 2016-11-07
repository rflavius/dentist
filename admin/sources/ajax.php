<?php


switch($_GET['type'])
{
	case 'calculate_total':
		$pk = new Pachete_Servicii($db);
		$pachet = $pk->getPachetInfo($_GET['pk']);
		if($_GET['pk']=='1')
		{
			$total = 0;
			$pachet_serv = explode(";",$_GET['servicii']);
			foreach($pachet_serv as $ky3 => $val3)
			{
				if($val3!='')
				{
					$serv = $pk->getServiciuInfo($val3);
					$total+=$serv['price'];
				}
			}
			
			echo $total;exit;
		}
		else
		{
			echo $pachet['pret'];exit;
		}
	break;
	
	case 'free_servicii':
		$pk = new Pachete_Servicii($db);
		$free_servs = $pk->listFreeServicii();
		$free='';
		foreach($free_servs as $ky=>$val)
		{
			$free.=';'.$val['id'];
		}
		echo $free;exit;
	break;
	
	case 'generate_factura_text':
		$pk = new Facturi($db);
		$text = $pk->generateFacturaText($_GET['pk'],$_GET['servicii'],$_GET['cabid']);
		echo $text;exit;
	break;
}




?>