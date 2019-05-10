<?php
/**
 * Created by Eduardo de Jesus
 * 
 * Unique creator
 */
require_once('../../../coneccion.php');
$idioma='es';
include('../../../idiomas/'.$idioma.'.php');
session_start(); 
$canal=$_GET['canal'];
$accion=$_GET['accion'];
$tip=$_GET['tipo'];
$codigo1=$_GET['codigo'];
$extra="";
  	
	
	
  $squery="select p.mastersku as mastersku,tb.amazonsku as amazonsku,tb.unitbundle as unitbundle,p.keywords as keywords,tb.prodname as prodname,p.metatitles as metatitles,p.descprod as description,tb.asin as asin,p.prodname as prodnameprod ,(select channel from cat_sal_cha ch where ch.codchan=tb.codcanal) as canal,(select nombre from cat_manufacturadores m where m.codmanufac=p.codmanufac) manuf,(select nombre from cat_marcas m where m.codmarca=p.marca) marca,tb.asin as asin,p.descprod as descripcion,imaurlbase as imagen1,(select file from cat_prod_img cpp where cpp.codprod=p.codprod limit 1 ) as imagen2 from tra_bun_det tb inner join cat_prod p on p.mastersku=tb.mastersku where tb.codcanal='$canal' ".$extra." limit 300"; 
 

$resultado = mysqli_query ( conexion($_SESSION['pais']),$squery);
 $registros = mysqli_num_rows ($resultado);
 
 if ($registros > 0) 
{
   require_once ('../../../lib/PHPExcel/PHPExcel.php');
   require_once('../../../coneccion.php');
$title="Bundles_Canal_Categorias";
   $objPHPExcel = new PHPExcel();
   if($tip=="H")
		{
$title= 'PlantillaAmazonMedicina.xlsx';

		}
	if($tip=="G")
		{
$title= 'PlantillaAmazonMedicina.xlsx';

		}
   //Informacion del excel
   $objPHPExcel->
    getProperties()
        ->setCreator("www.SigefCloud.com")
        ->setLastModifiedBy("www.SigefCloud.com")
        ->setTitle($title)
        ->setSubject("Reporte_Bundles")
        ->setDescription("Reporte de Bundles")
        ->setKeywords("Bundles")
        ->setCategory("ciudades");  
		if($tip=="G")
		{
			$tipo="TemplateType=foodandbeverages";  
		
			$B1="Version=2015.0611";
			$C1="The top 3 rows are for Amazon.com use only. Do not modify or delete the top 3 rows.";
			$K1="Offer - These attributes are required to make your item buyable for customers on the site";
			$AE="Dimensions - These attributes specify the size and weight of a product";
			$AM="Discovery - These attributes have an effect on how customers can find your product on the site using browse or search";
			$BH="Images - These attributes provide links to images for a product";
			$BQ="Fulfillment - Use these columns to provide fulfillment-related information for either Amazon-fulfilled (FBA) or seller-fulfilled orders.";
			$BX="Variation - Populate these attributes if your product is available in different variations (for example color or wattage)";
			$CB="Compliance - Attributes used to comply with consumer laws in the country or region where the item is sold";
			$CI="Ungrouped - These attributes create rich product listings for your buyers.";
			$L1="";
			$AG="";
			$AO="";
			$BW="";
			$CG="";
			$CL="";
			$CH="";
			$CT="";
			
		}
		else
		if($tip=="H")
		{
			$tipo="TemplateType=Health";  
		
			$B1="Version=2014.1119";
			$C1="The top 3 rows are for Amazon.com use only. Do not modify or delete the top 3 rows.";
			$K1="";
			$L1="Offer - These attributes are required to make your item buyable for customers on the site";
			$AE="";
			$AG="Dimension - These attributes specify the size and weight of a product";
			$AM="";
			$AO="Discovery - These attributes have an effect on how customers can find your product on the site using browse or search";
			$BH="";
			$BW="Image - These attributes provide links to images for a product";
			$BQ="";
			$CG="Fulfillment - Use these columns to provide fulfillment-related information for either Amazon-fulfilled (FBA) or seller-fulfilled orders.";
			$BX="";
			$CB="";
			$CI="";
			$CH="Variation - Populate these attributes if your product is available in different variations (for example color or wattage)";
			$CL="Compliance - Attributes used to comply with consumer laws in the country or region where the item is sold";
			$CT="Ungrouped - These attributes create rich product listings for your buyers.";
			
		}
	$o = 0;
	$i = 1;
	$objPHPExcel->setActiveSheetIndex($o)
            ->setCellValue('A'.$i, $tipo)
			->setCellValue('B'.$i, $B1)
			->setCellValue('C'.$i, $C1)
			->setCellValue('K'.$i, $K1)
			->setCellValue('AE'.$i, $AE)
			->setCellValue('AM'.$i, $AM)
			->setCellValue('BH'.$i, $BH)
			->setCellValue('BQ'.$i, $BQ)
			->setCellValue('BX'.$i, $BX)
			->setCellValue('CB'.$i, $CB)
			->setCellValue('CI'.$i, $CI)
			->setCellValue('CB'.$i, $CB)
			->setCellValue('L'.$i, $L1)
			->setCellValue('AG'.$i, $AG)
			->setCellValue('AO'.$i, $AO)
			->setCellValue('BW'.$i, $BW)
			->setCellValue('CG'.$i, $CG)
			->setCellValue('CL'.$i, $CL)
			->setCellValue('CH'.$i, $CH)
			->setCellValue('CT'.$i, $CT);
	$i = 2;
							
	if($tip=="H")
		{			
		
            $dato['A']['2']="SKU";
            $dato['B']['2']="Product Name";
            $dato['C']['2']="Product ID";
            $dato['D']['2']="Product ID Type";
			$dato['E']['2']="Product Type";
			$dato['F']['2']="Brand Name";
			$dato['G']['2']="Manufacturer";
			$dato['H']['2']="Manufacturer Part Number";
			$dato['I']['2']="Product Description";
			$dato['J']['2']="Item Type Keyword";
			$dato['K']['2']="Update Delete";
			$dato['L']['2']="Manufacturer's Suggested Retail Price";
			$dato['M']['2']="Standard Price";
			$dato['N']['2']="Currency";
			$dato['O']['2']="Quantity";
			$dato['P']['2']="Launch Date";
			$dato['Q']['2']="Offering Release Date";
			$dato['R']['2']="Restock Date";
			$dato['S']['2']="Fulfillment Latency";
			$dato['T']['2']="Max Aggregate Ship Quantity";
			$dato['U']['2']="Sale Price";
			$dato['V']['2']="Sale Start Date";
			$dato['W']['2']="Sale End Date";
			$dato['X']['2']="Package Quantity";
			$dato['Y']['2']="Product Tax Code";
			$dato['Z']['2']="Max Order Quantity";
			$dato['AA']['2']="Offering Can Be Gift Messaged";
			$dato['AB']['2']="Is Gift Wrap Available";
			$dato['AC']['2']="Is Discontinued by Manufacturer";
			$dato['AD']['2']="Product ID Override";
			$dato['AE']['2']="Number of Items";
			$dato['AF']['2']="Scheduled Delivery SKU List";
			$dato['AG']['2']="Item Weight Unit Of Measure";
			$dato['AH']['2']="Item Weight";
			$dato['AI']['2']="Item Length Unit Of Measure";
			$dato['AJ']['2']="Item Length";
			$dato['AK']['2']="Item Width";
			$dato['AL']['2']="Item Height";
			$dato['AM']['2']="Website Shipping Weight Unit Of Measure";
			$dato['AN']['2']="Shipping Weight";
			$dato['AO']['2']="Key Product Features1";
			$dato['AP']['2']="Key Product Features2";
			$dato['AQ']['2']="Key Product Features3";
			$dato['AR']['2']="Key Product Features4";
			$dato['AS']['2']="Key Product Features5";
			$dato['AT']['2']="Catalog Number";
			$dato['AU']['2']="Search Terms1";
			$dato['AV']['2']="Search Terms2";
			$dato['AW']['2']="Search Terms3";
			$dato['AX']['2']="Search Terms4";
			$dato['AY']['2']="Search Terms5";
			$dato['AZ']['2']="Intended Use1";
			$dato['BA']['2']="Intended Use2";
			$dato['BB']['2']="Intended Use3";
			$dato['BC']['2']="Intended Use4";
			$dato['BD']['2']="Intended Use5";
			$dato['BE']['2']="Subject Matter1";
			$dato['BF']['2']="Subject Matter2";
			$dato['BG']['2']="Subject Matter3";
			$dato['BH']['2']="Subject Matter4";
			$dato['BI']['2']="Subject Matter5";
			$dato['BJ']['2']="Target Audience1";
			$dato['BK']['2']="Target Audience2";
			$dato['BL']['2']="Target Audience3";
			$dato['BM']['2']="Other Attributes1";
			$dato['BN']['2']="Other Attributes2";
			$dato['BO']['2']="Other Attributes3";
			$dato['BP']['2']="Other Attributes4";
			$dato['BQ']['2']="Other Attributes5";
			$dato['BR']['2']="Platinum Keywords1";
			$dato['BS']['2']="Platinum Keywords2";
			$dato['BT']['2']="Platinum Keywords3";
			$dato['BU']['2']="Platinum Keywords4";
			$dato['BV']['2']="Platinum Keywords5";
			$dato['BW']['2']="Main Image URL";
			$dato['BX']['2']="Swatch Image URL";
			$dato['BY']['2']="Other Image URL1";
			$dato['BZ']['2']="Other Image URL2";
			$dato['CA']['2']="Other Image URL3";
			$dato['CB']['2']="Other Image URL4";
			$dato['CC']['2']="Other Image URL5";
			$dato['CD']['2']="Other Image URL6";
			$dato['CE']['2']="Other Image URL7";
			$dato['CF']['2']="Other Image URL8";
			$dato['CG']['2']="Fulfillment Center ID";
			$dato['CH']['2']="Parentage";
			$dato['CI']['2']="Parent SKU";
			$dato['CJ']['2']="Relationship Type";
			$dato['CK']['2']="Variation Theme";
			$dato['CL']['2']="Safety Warning";
			$dato['CM']['2']="Legal Disclaimer";
			$dato['CN']['2']="Consumer Notice";
			$dato['CO']['2']="CPSIA Cautionary Statement1";
			$dato['CP']['2']="CPSIA Cautionary Statement2";
			$dato['CQ']['2']="CPSIA Cautionary Statement3";
			$dato['CR']['2']="CPSIA Cautionary Statement4";
			$dato['CS']['2']="CPSIA Cautionary Description";
			$dato['CT']['2']="Ingredients1";
			$dato['CU']['2']="Ingredients2";
			$dato['CV']['2']="Ingredients3";
			$dato['CW']['2']="Indications";
			$dato['CX']['2']="Directions";
			$dato['CY']['2']="Minimum Weight Recommendation";
			$dato['CZ']['2']="Weight Supported";
			$dato['DA']['2']="Weight Recommendation Unit of Measure";
			$dato['DB']['2']="Flavor";
			$dato['DC']['2']="Size";
			$dato['DD']['2']="Color";
			$dato['DE']['2']="Scent Name";
			$dato['DF']['2']="Coverage";
			$dato['DG']['2']="Finish Types";
			$dato['DH']['2']="Item Form";
			$dato['DI']['2']="Material Type1";
			$dato['DJ']['2']="Material Type2";
			$dato['DK']['2']="Material Type3";
			$dato['DL']['2']="Specialty1";
			$dato['DM']['2']="Specialty2";
			$dato['DN']['2']="Specialty3";
			$dato['DO']['2']="Specialty4";
			$dato['DP']['2']="Specialty5";
			$dato['DQ']['2']="Target Gender";
			$dato['DR']['2']="Power Source";
			$dato['DS']['2']="AC Adapter Included";
			$dato['DT']['2']="Outside Diameter Derived";
			$dato['DU']['2']="Item Diameter Unit Of Measure";
			$dato['DV']['2']="Batteries are Included";
			$dato['DW']['2']="Are Batteries Required";
			$dato['DX']['2']="Battery Type1";
			$dato['DY']['2']="Battery Type2";
			$dato['DZ']['2']="Battery Type3";
			$dato['EA']['2']="Number of Batteries1";
			$dato['EB']['2']="Number of Batteries2";
			$dato['EC']['2']="Number of Batteries3";
			$dato['ED']['2']="Lithium Battery Energy Content";
			$dato['EE']['2']="Lithium Battery Packaging";
			$dato['EF']['2']="Lithium Battery Voltage";
			$dato['EG']['2']="Lithium Battery Weight";
			$dato['EH']['2']="Number of Lithium-ion Cells";
			$dato['EI']['2']="Number of Lithium Metal Cells";
			$dato['EJ']['2']="Adult Product";
			$dato['EK']['2']="Style Name";
			$dato['EL']['2']="Package Size Name";
			$dato['EM']['2']="Each Unit Count";
			$dato['EN']['2']="Total Eaches";
			$dato['EO']['2']="Unit Count";
			$dato['EP']['2']="Unit Count Type";
		    $dato['EQ']['2']="Model Name";
			$dato['ER']['2']="Skin Type1";
			$dato['ES']['2']="Skin Type2";
			$dato['ET']['2']="Skin Type3";
			$dato['EU']['2']="Skin Type4";
            $dato['EV']['2']="Skin Tone1";
            $dato['EW']['2']="Skin Tone2";
            $dato['EX']['2']="Skin Tone3";
            $dato['EY']['2']="Skin Tone4";
            $dato['EZ']['2']="Skin Tone5";
            $dato['FA']['2']="Hair Type1";
            $dato['FB']['2']="Hair Type2";
            $dato['FC']['2']="Hair Type3";
            
             $dato['A']['3']="item_sku";
			 $dato['B']['3']="item_name";
			 $dato['C']['3']="external_product_id";
			 $dato['D']['3']="external_product_id_type";
			 $dato['E']['3']="feed_product_type";
			 $dato['F']['3']="brand_name";
			 $dato['G']['3']="manufacturer";
			 $dato['H']['3']="part_number";
			 $dato['I']['3']="product_description";
			 $dato['J']['3']="item_type";
			 $dato['K']['3']="update_delete";
			 $dato['L']['3']="list_price";
			 $dato['M']['3']="standard_price";
			 $dato['N']['3']="currency";
			 $dato['O']['3']="quantity";
			 $dato['P']['3']="product_site_launch_date";
			 $dato['Q']['3']="merchant_release_date";
			 $dato['R']['3']="restock_date";
			 $dato['S']['3']="fulfillment_latency";
			 $dato['T']['3']="max_aggregate_ship_quantity";
			 $dato['U']['3']="sale_price";
			 $dato['V']['3']="sale_from_date";
			 $dato['W']['3']="sale_end_date";
			 $dato['X']['3']="item_package_quantity";
			 $dato['Y']['3']="product_tax_code";
			 $dato['Z']['3']="max_order_quantity";
			 $dato['AA']['3']="offering_can_be_gift_messaged";
			 $dato['AB']['3']="offering_can_be_giftwrapped";
			 $dato['AC']['3']="is_discontinued_by_manufacturer";
			 $dato['AD']['3']="missing_keyset_reason";
			 $dato['AE']['3']="number_of_items";
			 $dato['AF']['3']="delivery_schedule_group_id";
			 $dato['AG']['3']="item_weight_unit_of_measure";
			 $dato['AH']['3']="item_weight";
			 $dato['AI']['3']="item_length_unit_of_measure";
			 $dato['AJ']['3']="item_length";
			 $dato['AK']['3']="item_width";
			 $dato['AL']['3']="item_height";
			 $dato['AM']['3']="website_shipping_weight_unit_of_measure";
			 $dato['AN']['3']="website_shipping_weight";
			 $dato['AO']['3']="bullet_point1";
			 $dato['AP']['3']="bullet_point2";
			 $dato['AQ']['3']="bullet_point3";
			 $dato['AR']['3']="bullet_point4";
			 $dato['AS']['3']="bullet_point5";
			 $dato['AT']['3']="catalog_number";
			 $dato['AU']['3']="generic_keywords1";
			 $dato['AV']['3']="generic_keywords2";
			 $dato['AW']['3']="generic_keywords3";
			 $dato['AX']['3']="generic_keywords4";
			 $dato['AY']['3']="generic_keywords5";
			 $dato['AZ']['3']="specific_uses_keywords1";
			 $dato['BA']['3']="specific_uses_keywords2";
			 $dato['BB']['3']="specific_uses_keywords3";
			 $dato['BC']['3']="specific_uses_keywords4";
			 $dato['BD']['3']="specific_uses_keywords5";
			 $dato['BE']['3']="thesaurus_subject_keywords1";
			 $dato['BF']['3']="thesaurus_subject_keywords2";
			 $dato['BG']['3']="thesaurus_subject_keywords3";
			 $dato['BH']['3']="thesaurus_subject_keywords4";
			 $dato['BI']['3']="thesaurus_subject_keywords5";
			 $dato['BJ']['3']="target_audience_keywords1";
			 $dato['BK']['3']="target_audience_keywords2";
			 $dato['BL']['3']="target_audience_keywords3";
			 $dato['BM']['3']="thesaurus_attribute_keywords1";
			 $dato['BN']['3']="thesaurus_attribute_keywords2";
			 $dato['BO']['3']="thesaurus_attribute_keywords3";
			 $dato['BP']['3']="thesaurus_attribute_keywords4";
			 $dato['BQ']['3']="thesaurus_attribute_keywords5";
			 $dato['BR']['3']="platinum_keywords1";
			 $dato['BS']['3']="platinum_keywords2";
			 $dato['BT']['3']="platinum_keywords3";
			 $dato['BU']['3']="platinum_keywords4";
			 $dato['BV']['3']="platinum_keywords5";
			 $dato['BW']['3']="main_image_url";
			 $dato['BX']['3']="swatch_image_url";
			 $dato['BY']['3']="other_image_url1";
			 $dato['BZ']['3']="other_image_url2";
			 $dato['CA']['3']="other_image_url3";
			 $dato['CB']['3']="other_image_url4";
			 $dato['CC']['3']="other_image_url5";
			 $dato['CD']['3']="other_image_url6";
			 $dato['CE']['3']="other_image_url7";
			 $dato['CF']['3']="other_image_url8";
			 $dato['CG']['3']="fulfillment_center_id";
			 $dato['CH']['3']="parent_child";
			 $dato['CI']['3']="parent_sku";
			 $dato['CJ']['3']="relationship_type";
			 $dato['CK']['3']="variation_theme";
			 $dato['CL']['3']="safety_warning";
			 $dato['CM']['3']="legal_disclaimer_description";
			 $dato['CN']['3']="prop_65";
			 $dato['CO']['3']="cpsia_cautionary_statement1";
			 $dato['CP']['3']="cpsia_cautionary_statement2";
			 $dato['CQ']['3']="cpsia_cautionary_statement3";
			 $dato['CR']['3']="cpsia_cautionary_statement4";
			 $dato['CS']['3']="cpsia_cautionary_description";
			 $dato['CT']['3']="ingredients1";
			 $dato['CU']['3']="ingredients2";
			 $dato['CV']['3']="ingredients3";
			 $dato['CW']['3']="indications";
			 $dato['CX']['3']="directions";
			 $dato['CY']['3']="minimum_weight_recommendation";
			 $dato['CZ']['3']="maximum_weight_recommendation";
			 $dato['DA']['3']="weight_recommendation_unit_of_measure";
			 $dato['DB']['3']="flavor_name";
			 $dato['DC']['3']="size_name";
			 $dato['DD']['3']="color_name";
			 $dato['DE']['3']="scent_name";
			 $dato['DF']['3']="coverage";
			 $dato['DG']['3']="finish_type";
			 $dato['DH']['3']="item_form";
			 $dato['DI']['3']="material_type1";
			 $dato['DJ']['3']="material_type2";
			 $dato['DK']['3']="material_type3";
			 $dato['DL']['3']="specialty1";
			 $dato['DM']['3']="specialty2";
			 $dato['DN']['3']="specialty3";
			 $dato['DO']['3']="specialty4";
			 $dato['DP']['3']="specialty5";
			 $dato['DQ']['3']="target_gender";
			 $dato['DR']['3']="power_source_type";
			 $dato['DS']['3']="includes_ac_adapter";
			 $dato['DT']['3']="item_diameter_derived";
			 $dato['DU']['3']="item_diameter_unit_of_measure";
			 $dato['DV']['3']="are_batteries_included";
			 $dato['DW']['3']="batteries_required";
			 $dato['DX']['3']="battery_type1";
			 $dato['DY']['3']="battery_type2";
			 $dato['DZ']['3']="battery_type3";
			 $dato['EA']['3']="number_of_batteries1";
			 $dato['EB']['3']="number_of_batteries2";
			 $dato['EC']['3']="number_of_batteries3";
			 $dato['ED']['3']="lithium_battery_energy_content";
			 $dato['EE']['3']="lithium_battery_packaging";
			 $dato['EF']['3']="lithium_battery_voltage";
			 $dato['EG']['3']="lithium_battery_weight";
			 $dato['EH']['3']="number_of_lithium_ion_cells";
			 $dato['EI']['3']="number_of_lithium_metal_cells";
			 $dato['EJ']['3']="is_adult_product";
			 $dato['EK']['3']="style_name";
			 $dato['EL']['3']="package_size_name";
			 $dato['EM']['3']="each_unit_count";
			 $dato['EN']['3']="total_eaches";
			 $dato['EO']['3']="unit_count";
			 $dato['EP']['3']="unit_count_type";
			 $dato['EQ']['3']="model_name";
			 $dato['ER']['3']="skin_type1";
			 $dato['ES']['3']="skin_type2";
			 $dato['ET']['3']="skin_type3";
			 $dato['EU']['3']="skin_type4";
			 $dato['EV']['3']="skin_tone1";
			 $dato['EW']['3']="skin_tone2";
			 $dato['EX']['3']="skin_tone3";
			 $dato['EY']['3']="skin_tone4";
			 $dato['EZ']['3']="skin_tone5";
			 $dato['FA']['3']="hair_type1";
			 $dato['FB']['3']="hair_type2";
			 $dato['FC']['3']="hair_type3";

            
		}
		
	if($tip=="G")
		{
			$dato['A']['2']="SKU";
			$dato['B']['2']="Product ID";
			$dato['C']['2']="Product ID Type";
			$dato['D']['2']="Product Name";
			$dato['E']['2']="Brand Name";
			$dato['F']['2']="Manufacturer";
			$dato['G']['2']="Product Description";
			$dato['H']['2']="Product Type";
			$dato['I']['2']="Item Type Keyword";
			$dato['J']['2']="Update Delete";
			$dato['K']['2']="Package Quantity";
			$dato['L']['2']="Standard Price";
			$dato['M']['2']="Manufacturer's Suggested Retail Price";
			$dato['N']['2']="Currency";
			$dato['O']['2']="Quantity";
			$dato['P']['2']="Sale Price";
			$dato['Q']['2']="Sale Start Date";
			$dato['R']['2']="Sale End Date";
			$dato['S']['2']="Number of Items";
			$dato['T']['2']="Product Tax Code";
			$dato['U']['2']="Launch Date";
			$dato['V']['2']="Offering Release Date";
			$dato['W']['2']="Fulfillment Latency";
			$dato['X']['2']="Restock Date";
			$dato['Y']['2']="Max Aggregate Ship Quantity";
			$dato['Z']['2']="Offering Can Be Gift Messaged";
			$dato['AA']['2']="Is Gift Wrap Available";
			$dato['AB']['2']="Is Discontinued by Manufacturer";
			$dato['AC']['2']="Registered Parameter";
			$dato['AD']['2']="Scheduled Delivery SKU List";
			$dato['AE']['2']="Shipping Weight";
			$dato['AF']['2']="Website Shipping Weight Unit Of Measure";
			$dato['AG']['2']="Item Length Unit Of Measure";
			$dato['AH']['2']="Item Length";
			$dato['AI']['2']="Item Width";
			$dato['AJ']['2']="Item Height";
			$dato['AK']['2']="Item Weight";
			$dato['AL']['2']="Item Weight Unit Of Measure";
			$dato['AM']['2']="Key Product Features1";
			$dato['AN']['2']="Key Product Features2";
			$dato['AO']['2']="Key Product Features3";
			$dato['AP']['2']="Key Product Features4";
			$dato['AQ']['2']="Key Product Features5";
			$dato['AR']['2']="Intended Use1";
			$dato['AS']['2']="Intended Use2";
			$dato['AT']['2']="Intended Use3";
			$dato['AU']['2']="Intended Use4";
			$dato['AV']['2']="Intended Use5";
			$dato['AW']['2']="Search Terms1";
			$dato['AX']['2']="Search Terms2";
			$dato['AY']['2']="Search Terms3";
			$dato['AZ']['2']="Search Terms4";
			$dato['BA']['2']="Search Terms5";
			$dato['BB']['2']="Platinum Keywords1";
			$dato['BC']['2']="Platinum Keywords2";
			$dato['BD']['2']="Platinum Keywords3";
			$dato['BE']['2']="Platinum Keywords4";
			$dato['BF']['2']="Platinum Keywords5";
			$dato['BG']['2']="Catalog Number";
			$dato['BH']['2']="Main Image URL";
			$dato['BI']['2']="Other Image URL1";
			$dato['BJ']['2']="Other Image URL2";
			$dato['BK']['2']="Other Image URL3";
			$dato['BL']['2']="Other Image URL4";
			$dato['BM']['2']="Other Image URL5";
			$dato['BN']['2']="Other Image URL6";
			$dato['BO']['2']="Other Image URL7";
			$dato['BP']['2']="Other Image URL8";
			$dato['BQ']['2']="Fulfillment Center ID";
			$dato['BR']['2']="Package Height";
			$dato['BS']['2']="Package Width";
			$dato['BT']['2']="Package Length";
			$dato['BU']['2']="Package Length Unit Of Measure";
			$dato['BV']['2']="Package Weight";
			$dato['BW']['2']="Package Weight Unit Of Measure";
			$dato['BX']['2']="Parentage";
			$dato['BY']['2']="Parent SKU";
			$dato['BZ']['2']="Relationship Type";
			$dato['CA']['2']="Variation Theme";
			$dato['CB']['2']="Country of declaration";
			$dato['CC']['2']="Legal Disclaimer";
			$dato['CD']['2']="Consumer Notice";
			$dato['CE']['2']="Cpsia Warning1";
			$dato['CF']['2']="Cpsia Warning2";
			$dato['CG']['2']="Cpsia Warning3";
			$dato['CH']['2']="Cpsia Warning4";
			$dato['CI']['2']="Other Attributes1";
			$dato['CJ']['2']="Other Attributes2";
			$dato['CK']['2']="Other Attributes3";
			$dato['CL']['2']="Other Attributes4";
			$dato['CM']['2']="Other Attributes5";
			$dato['CN']['2']="Size";
			$dato['CO']['2']="Flavor";
			$dato['CP']['2']="Cuisine";
			$dato['CQ']['2']="Directions";
			$dato['CR']['2']="Ingredients";
			$dato['CS']['2']="Specialty ingredients1";
			$dato['CT']['2']="Specialty ingredients2";
			$dato['CU']['2']="Specialty ingredients3";
			$dato['CV']['2']="Specialty ingredients4";
			$dato['CW']['2']="Specialty ingredients5";
			$dato['CX']['2']="Unit Count";
			$dato['CY']['2']="Unit Count Type";
			$dato['CZ']['2']="Container Material Type";
			$dato['DA']['2']="Container Volume";
			$dato['DB']['2']="Temperature Rating";
			$dato['DC']['2']="Style Name";
			$dato['DD']['2']="Package Size Name";
			$dato['DE']['2']="Each Unit Count";
			$dato['DF']['2']="Total Eaches";
			$dato['DG']['2']="Product Expiration Type";
			$dato['DH']['2']="Shelf Life";
			$dato['DI']['2']="Shelf Life Pad Time";
			$dato['DJ']['2']="Shelf Life Pad Time 2";
			$dato['DK']['2']="Receive Pad Time";
			$dato['DL']['2']="Flash Point";
			$dato['DM']['2']="Hazmat Exception";
			$dato['DN']['2']="Hazmat Proper Shipping Name";
			$dato['DO']['2']="Hazmat Regulatory Packing Group";
			$dato['DP']['2']="Hazmat Storage Regulatory Class";
			$dato['DQ']['2']="Hazmat Transportation Regulatory Class";
			$dato['DR']['2']="Hazmat Type";
			$dato['DS']['2']="Hazmat United Nations Regulatory ID";
			$dato['DT']['2']="Sales Restriction";
			$dato['DU']['2']="";
            $dato['DV']['2']="";
            $dato['DW']['2']="";
            $dato['DX']['2']="";
            $dato['DY']['2']="";
            $dato['DZ']['2']="";
            $dato['EA']['2']="";
            $dato['EB']['2']="";
            $dato['EC']['2']="";
            $dato['ED']['2']="";
            $dato['EE']['2']="";
            $dato['EF']['2']="";
            $dato['EG']['2']="";
            $dato['EH']['2']="";
            $dato['EI']['2']="";
            $dato['EJ']['2']="";
            $dato['EK']['2']="";
            $dato['EL']['2']="";
            $dato['EM']['2']="";
            $dato['EN']['2']="";
            $dato['EO']['2']="";
            $dato['EP']['2']="";
            $dato['EQ']['2']="";
            $dato['ER']['2']="";
            $dato['ES']['2']="";
            $dato['ET']['2']="";
            $dato['EU']['2']="";
            $dato['EV']['2']="";
            $dato['EW']['2']="";
            $dato['EX']['2']="";
            $dato['EY']['2']="";
            $dato['EZ']['2']="";
            $dato['FA']['2']="";
            $dato['FB']['2']="";
            $dato['FC']['2']="";
        	
            $dato['A']['3']="item_sku";
			$dato['B']['3']="external_product_id";
			$dato['C']['3']="external_product_id_type";
			$dato['D']['3']="item_name";
			$dato['E']['3']="brand_name";
			$dato['F']['3']="manufacturer";
			$dato['G']['3']="product_description";
			$dato['H']['3']="feed_product_type";
			$dato['I']['3']="item_type";
			$dato['J']['3']="update_delete";
			$dato['K']['3']="item_package_quantity";
			$dato['L']['3']="standard_price";
			$dato['M']['3']="list_price";
			$dato['N']['3']="currency";
			$dato['O']['3']="quantity";
			$dato['P']['3']="sale_price";
			$dato['Q']['3']="sale_from_date";
			$dato['R']['3']="sale_end_date";
			$dato['S']['3']="number_of_items";
			$dato['T']['3']="product_tax_code";
			$dato['U']['3']="product_site_launch_date";
			$dato['V']['3']="merchant_release_date";
			$dato['W']['3']="fulfillment_latency";
			$dato['X']['3']="restock_date";
			$dato['Y']['3']="max_aggregate_ship_quantity";
			$dato['Z']['3']="offering_can_be_gift_messaged";
			$dato['AA']['3']="offering_can_be_giftwrapped";
			$dato['AB']['3']="is_discontinued_by_manufacturer";
			$dato['AC']['3']="missing_keyset_reason";
			$dato['AD']['3']="delivery_schedule_group_id";
			$dato['AE']['3']="website_shipping_weight";
			$dato['AF']['3']="website_shipping_weight_unit_of_measure";
			$dato['AG']['3']="item_length_unit_of_measure";
			$dato['AH']['3']="item_length";
			$dato['AI']['3']="item_width";
			$dato['AJ']['3']="item_height";
			$dato['AK']['3']="item_weight";
			$dato['AL']['3']="item_weight_unit_of_measure";
			$dato['AM']['3']="bullet_point1";
			$dato['AN']['3']="bullet_point2";
			$dato['AO']['3']="bullet_point3";
			$dato['AP']['3']="bullet_point4";
			$dato['AQ']['3']="bullet_point5";
			$dato['AR']['3']="specific_uses_keywords1";
			$dato['AS']['3']="specific_uses_keywords2";
			$dato['AT']['3']="specific_uses_keywords3";
			$dato['AU']['3']="specific_uses_keywords4";
			$dato['AV']['3']="specific_uses_keywords5";
			$dato['AW']['3']="generic_keywords1";
			$dato['AX']['3']="generic_keywords2";
			$dato['AY']['3']="generic_keywords3";
			$dato['AZ']['3']="generic_keywords4";
			$dato['BA']['3']="generic_keywords5";
			$dato['BB']['3']="platinum_keywords1";
			$dato['BC']['3']="platinum_keywords2";
			$dato['BD']['3']="platinum_keywords3";
			$dato['BE']['3']="platinum_keywords4";
			$dato['BF']['3']="platinum_keywords5";
			$dato['BG']['3']="catalog_number";
			$dato['BH']['3']="main_image_url";
			$dato['BI']['3']="other_image_url1";
			$dato['BJ']['3']="other_image_url2";
			$dato['BK']['3']="other_image_url3";
			$dato['BL']['3']="other_image_url4";
			$dato['BM']['3']="other_image_url5";
			$dato['BN']['3']="other_image_url6";
			$dato['BO']['3']="other_image_url7";
			$dato['BP']['3']="other_image_url8";
			$dato['BQ']['3']="fulfillment_center_id";
			$dato['BR']['3']="package_height";
			$dato['BS']['3']="package_width";
			$dato['BT']['3']="package_length";
			$dato['BU']['3']="package_length_unit_of_measure";
			$dato['BV']['3']="package_weight";
			$dato['BW']['3']="package_weight_unit_of_measure";
			$dato['BX']['3']="parent_child";
			$dato['BY']['3']="parent_sku";
			$dato['BZ']['3']="relationship_type";
			$dato['CA']['3']="variation_theme";
			$dato['CB']['3']="country_string";
			$dato['CC']['3']="legal_disclaimer_description";
			$dato['CD']['3']="prop_65";
			$dato['CE']['3']="cpsia_cautionary_statement1";
			$dato['CF']['3']="cpsia_cautionary_statement2";
			$dato['CG']['3']="cpsia_cautionary_statement3";
			$dato['CH']['3']="cpsia_cautionary_statement4";
			$dato['CI']['3']="thesaurus_attribute_keywords1";
			$dato['CJ']['3']="thesaurus_attribute_keywords2";
			$dato['CK']['3']="thesaurus_attribute_keywords3";
			$dato['CL']['3']="thesaurus_attribute_keywords4";
			$dato['CM']['3']="thesaurus_attribute_keywords5";
			$dato['CN']['3']="size_name";
			$dato['CO']['3']="flavor_name";
			$dato['CP']['3']="cuisine";
			$dato['CQ']['3']="directions";
			$dato['CR']['3']="ingredients";
			$dato['CS']['3']="special_ingredients1";
			$dato['CT']['3']="special_ingredients2";
			$dato['CU']['3']="special_ingredients3";
			$dato['CV']['3']="special_ingredients4";
			$dato['CW']['3']="special_ingredients5";
			$dato['CX']['3']="unit_count";
			$dato['CY']['3']="unit_count_type";
			$dato['CZ']['3']="container_material_type";
			$dato['DA']['3']="container_volume";
			$dato['DB']['3']="temperature_rating";
			$dato['DC']['3']="style_name";
			$dato['DD']['3']="package_size_name";
			$dato['DE']['3']="each_unit_count";
			$dato['DF']['3']="total_eaches";
			$dato['DG']['3']="product_expiration_type";
			$dato['DH']['3']="fc_shelf_life";
			$dato['DI']['3']="fc_shelf_life_pad_time";
			$dato['DJ']['3']="fc_shelf_life_pad_time_2q";
			$dato['DK']['3']="fc_receive_pad_time";
			$dato['DL']['3']="flash_point";
			$dato['DM']['3']="hazmat_exception";
			$dato['DN']['3']="hazmat_proper_shipping_name";
			$dato['DO']['3']="hazmat_regulatory_packing_group";
			$dato['DP']['3']="hazmat_storage_regulatory_class";
			$dato['DQ']['3']="hazmat_transportation_regulatory_class";
			$dato['DR']['3']="hazmat_type";
			$dato['DS']['3']="hazmat_united_nations_regulatory_id";
			$dato['DT']['3']="sales_restriction";
            $dato['DU']['3']="";
            $dato['DV']['3']="";
            $dato['DW']['3']="";
            $dato['DX']['3']="";
            $dato['DY']['3']="";
            $dato['DZ']['3']="";
            $dato['EA']['3']="";
            $dato['EB']['3']="";
            $dato['EC']['3']="";
            $dato['ED']['3']="";
            $dato['EE']['3']="";
            $dato['EF']['3']="";
            $dato['EG']['3']="";
            $dato['EH']['3']="";
            $dato['EI']['3']="";
            $dato['EJ']['3']="";
            $dato['EK']['3']="";
            $dato['EL']['3']="";
            $dato['EM']['3']="";
            $dato['EN']['3']="";
            $dato['EO']['3']="";
            $dato['EP']['3']="";
            $dato['EQ']['3']="";
            $dato['ER']['3']="";
            $dato['ES']['3']="";
            $dato['ET']['3']="";
            $dato['EU']['3']="";
            $dato['EV']['3']="";
            $dato['EW']['3']="";
            $dato['EX']['3']="";
            $dato['EY']['3']="";
            $dato['EZ']['3']="";
            $dato['FA']['3']="";
            $dato['FB']['3']="";
            $dato['FC']['3']="";


		}
		
     
     while($i<=3)
     {
	$objPHPExcel->setActiveSheetIndex($o)
            ->setCellValue('A'.$i, $dato['A'][$i])
			->setCellValue('B'.$i, $dato['B'][$i])
			->setCellValue('C'.$i, $dato['C'][$i])
			->setCellValue('D'.$i, $dato['D'][$i])
			->setCellValue('E'.$i, $dato['E'][$i])
			->setCellValue('F'.$i, $dato['F'][$i])
			->setCellValue('G'.$i, $dato['G'][$i])
			->setCellValue('H'.$i, $dato['H'][$i])
			->setCellValue('I'.$i, $dato['I'][$i])
			->setCellValue('J'.$i, $dato['J'][$i])
			->setCellValue('K'.$i, $dato['K'][$i])
			->setCellValue('L'.$i, $dato['L'][$i])
			->setCellValue('M'.$i, $dato['M'][$i])
			->setCellValue('N'.$i, $dato['N'][$i])
			->setCellValue('O'.$i, $dato['O'][$i])
			->setCellValue('P'.$i, $dato['P'][$i])
			->setCellValue('Q'.$i, $dato['Q'][$i])
			->setCellValue('R'.$i, $dato['R'][$i])
			->setCellValue('S'.$i, $dato['S'][$i])
			->setCellValue('T'.$i, $dato['T'][$i])
			->setCellValue('U'.$i, $dato['U'][$i])
			->setCellValue('V'.$i, $dato['V'][$i])
			->setCellValue('W'.$i, $dato['W'][$i])
			->setCellValue('X'.$i, $dato['X'][$i])
			->setCellValue('Y'.$i, $dato['Y'][$i])
			->setCellValue('Z'.$i, $dato['Z'][$i])
			->setCellValue('AA'.$i, $dato['AA'][$i])
			->setCellValue('AB'.$i, $dato['AB'][$i])
			->setCellValue('AC'.$i, $dato['AC'][$i])
			->setCellValue('AD'.$i, $dato['AD'][$i])
			->setCellValue('AE'.$i, $dato['AE'][$i])
			->setCellValue('AF'.$i, $dato['AF'][$i])
			->setCellValue('AG'.$i, $dato['AG'][$i])
			->setCellValue('AH'.$i, $dato['AH'][$i])
			->setCellValue('AI'.$i, $dato['AI'][$i])
			->setCellValue('AJ'.$i, $dato['AJ'][$i])
			->setCellValue('AK'.$i, $dato['AK'][$i])
			->setCellValue('AL'.$i, $dato['AL'][$i])
			->setCellValue('AM'.$i, $dato['AM'][$i])
			->setCellValue('AN'.$i, $dato['AN'][$i])
			->setCellValue('AO'.$i, $dato['AO'][$i])
			->setCellValue('AP'.$i, $dato['AP'][$i])
			->setCellValue('AQ'.$i, $dato['AQ'][$i])
			->setCellValue('AR'.$i, $dato['AR'][$i])
			->setCellValue('AS'.$i, $dato['AS'][$i])
			->setCellValue('AT'.$i, $dato['AT'][$i])
			->setCellValue('AU'.$i, $dato['AU'][$i])
			->setCellValue('AV'.$i, $dato['AV'][$i])
			->setCellValue('AW'.$i, $dato['AW'][$i])
			->setCellValue('AX'.$i, $dato['AX'][$i])
			->setCellValue('AY'.$i, $dato['AY'][$i])
			->setCellValue('AZ'.$i, $dato['AZ'][$i])
			->setCellValue('BA'.$i, $dato['BA'][$i])
			->setCellValue('BB'.$i, $dato['BB'][$i])
			->setCellValue('BC'.$i, $dato['BC'][$i])
			->setCellValue('BD'.$i, $dato['BD'][$i])
			->setCellValue('BE'.$i, $dato['BE'][$i])
			->setCellValue('BF'.$i, $dato['BF'][$i])
			->setCellValue('BG'.$i, $dato['BG'][$i])
			->setCellValue('BH'.$i, $dato['BH'][$i])
			->setCellValue('BI'.$i, $dato['BI'][$i])
			->setCellValue('BJ'.$i, $dato['BJ'][$i])
			->setCellValue('BK'.$i, $dato['BK'][$i])
			->setCellValue('BL'.$i, $dato['BL'][$i])
			->setCellValue('BM'.$i, $dato['BM'][$i])
			->setCellValue('BN'.$i, $dato['BN'][$i])
			->setCellValue('BO'.$i, $dato['BO'][$i])
			->setCellValue('BP'.$i, $dato['BP'][$i])
			->setCellValue('BQ'.$i, $dato['BQ'][$i])
			->setCellValue('BR'.$i, $dato['BR'][$i])
			->setCellValue('BS'.$i, $dato['BS'][$i])
			->setCellValue('BT'.$i, $dato['BT'][$i])
			->setCellValue('BU'.$i, $dato['BU'][$i])
			->setCellValue('BV'.$i, $dato['BV'][$i])
			->setCellValue('BW'.$i, $dato['BW'][$i])
			->setCellValue('BX'.$i, $dato['BX'][$i])
			->setCellValue('BY'.$i, $dato['BY'][$i])
			->setCellValue('BZ'.$i, $dato['BZ'][$i])
			->setCellValue('CA'.$i, $dato['CA'][$i])
			->setCellValue('CB'.$i, $dato['CB'][$i])
			->setCellValue('CC'.$i, $dato['CC'][$i])
			->setCellValue('CD'.$i, $dato['CD'][$i])
			->setCellValue('CE'.$i, $dato['CE'][$i])
			->setCellValue('CF'.$i, $dato['CF'][$i])
			->setCellValue('CG'.$i, $dato['CG'][$i])
			->setCellValue('CH'.$i, $dato['CH'][$i])
			->setCellValue('CI'.$i, $dato['CI'][$i])
			->setCellValue('CJ'.$i, $dato['CJ'][$i])
			->setCellValue('CK'.$i, $dato['CK'][$i])
			->setCellValue('CL'.$i, $dato['CL'][$i])
			->setCellValue('CM'.$i, $dato['CM'][$i])
			->setCellValue('CN'.$i, $dato['CN'][$i])
			->setCellValue('CO'.$i, $dato['CO'][$i])
			->setCellValue('CP'.$i, $dato['CP'][$i])
			->setCellValue('CQ'.$i, $dato['CQ'][$i])
			->setCellValue('CR'.$i, $dato['CR'][$i])
			->setCellValue('CS'.$i, $dato['CS'][$i])
			->setCellValue('CT'.$i, $dato['CT'][$i])
			->setCellValue('CU'.$i, $dato['CU'][$i])
			->setCellValue('CV'.$i, $dato['CV'][$i])
			->setCellValue('CW'.$i, $dato['CW'][$i])
			->setCellValue('CX'.$i, $dato['CX'][$i])
			->setCellValue('CY'.$i, $dato['CY'][$i])
			->setCellValue('CZ'.$i, $dato['CZ'][$i])
			->setCellValue('DA'.$i, $dato['DA'][$i])
			->setCellValue('DB'.$i, $dato['DB'][$i])
			->setCellValue('DC'.$i, $dato['DC'][$i])
			->setCellValue('DD'.$i, $dato['DD'][$i])
			->setCellValue('DE'.$i, $dato['DE'][$i])
			->setCellValue('DF'.$i, $dato['DF'][$i])
			->setCellValue('DG'.$i, $dato['DG'][$i])
			->setCellValue('DH'.$i, $dato['DH'][$i])
			->setCellValue('DI'.$i, $dato['DI'][$i])
			->setCellValue('DJ'.$i, $dato['DJ'][$i])
			->setCellValue('DK'.$i, $dato['DK'][$i])
			->setCellValue('DL'.$i, $dato['DL'][$i])
			->setCellValue('DM'.$i, $dato['DM'][$i])
			->setCellValue('DN'.$i, $dato['DN'][$i])
			->setCellValue('DO'.$i, $dato['DO'][$i])
			->setCellValue('DP'.$i, $dato['DP'][$i])
			->setCellValue('DQ'.$i, $dato['DQ'][$i])
			->setCellValue('DR'.$i, $dato['DR'][$i])
			->setCellValue('DS'.$i, $dato['DS'][$i])
			->setCellValue('DT'.$i, $dato['DT'][$i])
			->setCellValue('DU'.$i, $dato['DU'][$i])
			->setCellValue('DV'.$i, $dato['DV'][$i])
			->setCellValue('DW'.$i, $dato['DW'][$i])
			->setCellValue('DX'.$i, $dato['DX'][$i])
			->setCellValue('DY'.$i, $dato['DY'][$i])
			->setCellValue('DZ'.$i, $dato['DZ'][$i])
			->setCellValue('EA'.$i, $dato['EA'][$i])
			->setCellValue('EB'.$i, $dato['EB'][$i])
			->setCellValue('EC'.$i, $dato['EC'][$i])
			->setCellValue('ED'.$i, $dato['ED'][$i])
			->setCellValue('EE'.$i, $dato['EE'][$i])
			->setCellValue('EF'.$i, $dato['EF'][$i])
			->setCellValue('EG'.$i, $dato['EG'][$i])
			->setCellValue('EH'.$i, $dato['EH'][$i])
			->setCellValue('EI'.$i, $dato['EI'][$i])
			->setCellValue('EJ'.$i, $dato['EJ'][$i])
			->setCellValue('EK'.$i, $dato['EK'][$i])
			->setCellValue('EL'.$i, $dato['EL'][$i])
			->setCellValue('EM'.$i, $dato['EM'][$i])
			->setCellValue('EN'.$i, $dato['EN'][$i])
			->setCellValue('EO'.$i, $dato['EO'][$i])
			->setCellValue('EP'.$i, $dato['EP'][$i])
			->setCellValue('EQ'.$i, $dato['EQ'][$i])
			->setCellValue('ER'.$i, $dato['ER'][$i])
			->setCellValue('ES'.$i, $dato['ES'][$i])
			->setCellValue('ET'.$i, $dato['ET'][$i])
			->setCellValue('EU'.$i, $dato['EU'][$i])
			->setCellValue('EV'.$i, $dato['EV'][$i])
			->setCellValue('EW'.$i, $dato['EW'][$i])
			->setCellValue('EX'.$i, $dato['EX'][$i])
			->setCellValue('EY'.$i, $dato['EY'][$i])
			->setCellValue('EZ'.$i, $dato['EZ'][$i])
			->setCellValue('FA'.$i, $dato['FA'][$i])
			->setCellValue('FB'.$i, $dato['FB'][$i])
			->setCellValue('FC'.$i, $dato['FC'][$i]);
        $i++;
     }
	
	
   $i = 4;   
     
   while ($registro = mysqli_fetch_array($resultado,MYSQLI_ASSOC)) 
   {
	   
       $identificador="";
       $tipoIdentificador="";
       $update="";
       $precio="";
	   $imagenB="";
	   $imagen1="";
	   $imagen2="";
	   $imagen3="";
	   $imagen4="";
	   $imagen5="";
	   $imagen6="";
	   $imagen7="";
	   $imagen8="";
    	 
	 if($registro['unitbundle']=="1")
	 {		
	 
            $codigo=$registro['mastersku'];
     if($tip=="G")
		{   
	 $objPHPExcel->setActiveSheetIndex($o)
            ->setCellValue('A'.$i, $codigo)
			->setCellValue('B'.$i, $identificador)
			->setCellValue('C'.$i, $tipoIdentificador)
			->setCellValue('D'.$i, $registro['prodname'])
			->setCellValue('E'.$i, $registro['marca'])
			->setCellValue('F'.$i, $registro['manuf'])
			->setCellValue('G'.$i, $registro['prodname'])
			->setCellValue('H'.$i, ""/*categoria homologada*/)
			->setCellValue('I'.$i, ""/*subcategoria homologada*/)
			->setCellValue('J'.$i, $update)
			->setCellValue('K'.$i, '1')
			->setCellValue('L'.$i, $precio)
			->setCellValue('N'.$i, "USD")
			->setCellValue('O'.$i, "0")
			->setCellValue('AM'.$i, $registro['prodname'])
			->setCellValue('BH'.$i, $imagenB)
			->setCellValue('BI'.$i, $imagen1)
			->setCellValue('BJ'.$i, $imagen2)
			->setCellValue('BK'.$i, $imagen3)
			->setCellValue('BL'.$i, $imagen4)
			->setCellValue('BM'.$i, $imagen5)
			->setCellValue('BN'.$i, $imagen6)
			->setCellValue('BO'.$i, $imagen7)
			->setCellValue('BP'.$i, $imagen8)
			->setCellValue('BX'.$i, 'Parent')
			->setCellValue('BY'.$i, $registro['mastersku'])
			->setCellValue('BZ'.$i, 'Variation')
			->setCellValue('CA'.$i, 'SizeName')
			->setCellValue('CN'.$i, 'Pack of '.$registro['unitbundle'])
			->setCellValue('CX'.$i, '1')
			->setCellValue('CY'.$i, 'Count');
		}
		if($tip=="H")
		{
			$objPHPExcel->setActiveSheetIndex($o)
            ->setCellValue('A'.$i, $codigo)
			->setCellValue('B'.$i, $identificador)
			->setCellValue('C'.$i, $tipoIdentificador)
			->setCellValue('D'.$i, $registro['prodname'])
			->setCellValue('E'.$i, $registro['marca'])
			->setCellValue('F'.$i, $registro['manuf'])
			->setCellValue('G'.$i, $registro['prodname'])
			->setCellValue('H'.$i, ""/*categoria homologada*/)
			->setCellValue('I'.$i, ""/*subcategoria homologada*/)
			->setCellValue('J'.$i, $update)
			->setCellValue('K'.$i, '1')
			->setCellValue('L'.$i, $precio)
			->setCellValue('M'.$i, "")
			->setCellValue('N'.$i, "USD")
			->setCellValue('O'.$i, "0")
			->setCellValue('P'.$i, "")
			->setCellValue('Q'.$i, "")
			->setCellValue('R'.$i, "")
			->setCellValue('S'.$i, "")
			->setCellValue('T'.$i, "")
			->setCellValue('U'.$i, "")
			->setCellValue('V'.$i, "")
			->setCellValue('W'.$i, "")
			->setCellValue('X'.$i, "")
			->setCellValue('Y'.$i, "")
			->setCellValue('Z'.$i, "")
			->setCellValue('AA'.$i, "")
			->setCellValue('AB'.$i, "")
			->setCellValue('AC'.$i, "")
			->setCellValue('AD'.$i, "")
			->setCellValue('AE'.$i, "")
			->setCellValue('AF'.$i, "")
			->setCellValue('AG'.$i, "")
			->setCellValue('AH'.$i, "")
			->setCellValue('AI'.$i, "")
			->setCellValue('AJ'.$i, "")
			->setCellValue('AK'.$i, "")
			->setCellValue('AL'.$i, "")
			->setCellValue('AM'.$i, $registro['prodname'])
			->setCellValue('AN'.$i, '')
			->setCellValue('AO'.$i, '')
			->setCellValue('AP'.$i, '')
			->setCellValue('AQ'.$i, '')
			->setCellValue('AR'.$i, '')
			->setCellValue('AS'.$i, '')
			->setCellValue('AT'.$i, '')
			->setCellValue('AU'.$i, '')
			->setCellValue('AV'.$i, '')
			->setCellValue('AW'.$i, '')
			->setCellValue('AX'.$i, '')
			->setCellValue('AY'.$i, '')
			->setCellValue('AZ'.$i, '')
			->setCellValue('BA'.$i, '')
			->setCellValue('BB'.$i, '')
			->setCellValue('BC'.$i, '')
			->setCellValue('BD'.$i, '')
			->setCellValue('BE'.$i, '')
			->setCellValue('BF'.$i, '')
			->setCellValue('BG'.$i, '')
			->setCellValue('BH'.$i, $imagenB)
			->setCellValue('BI'.$i, $imagen1)
			->setCellValue('BJ'.$i, $imagen2)
			->setCellValue('BK'.$i, $imagen3)
			->setCellValue('BL'.$i, $imagen4)
			->setCellValue('BM'.$i, $imagen5)
			->setCellValue('BN'.$i, $imagen6)
			->setCellValue('BO'.$i, $imagen7)
			->setCellValue('BP'.$i, $imagen8)
			->setCellValue('BQ'.$i, '')
			->setCellValue('BR'.$i, '')
			->setCellValue('BS'.$i, '')
			->setCellValue('BT'.$i, '')
			->setCellValue('BU'.$i, '')
			->setCellValue('BV'.$i, '')
			->setCellValue('BW'.$i, '')
			->setCellValue('BX'.$i, 'Chinld')
			->setCellValue('BY'.$i, $registro['mastersku'])
			->setCellValue('BZ'.$i, 'Variation')
			->setCellValue('CA'.$i, 'SizeName')
			->setCellValue('CB'.$i, '')
			->setCellValue('CC'.$i, '')
			->setCellValue('CD'.$i, '')
			->setCellValue('CE'.$i, '')
			->setCellValue('CF'.$i, '')
			->setCellValue('CG'.$i, '')
			->setCellValue('CH'.$i, '')
			->setCellValue('CI'.$i, '')
			->setCellValue('CJ'.$i, '')
			->setCellValue('CK'.$i, '')
			->setCellValue('CL'.$i, '')
			->setCellValue('CM'.$i, '')
			->setCellValue('CN'.$i, 'Pack of '.$registro['unitbundle'])
			->setCellValue('CO'.$i, '')
			->setCellValue('CP'.$i, '')
			->setCellValue('CQ'.$i, '')
			->setCellValue('CR'.$i, '')
			->setCellValue('CS'.$i, '')
			->setCellValue('CT'.$i, '')
			->setCellValue('CU'.$i, '')
			->setCellValue('CV'.$i, '')
			->setCellValue('CW'.$i, '')
			->setCellValue('CX'.$i, '1')
			->setCellValue('CY'.$i, 'Count')
			->setCellValue('CZ'.$i, '')
			->setCellValue('DA'.$i, '')
			->setCellValue('DB'.$i, '')
			->setCellValue('DC'.$i, '')
			->setCellValue('DD'.$i, '')
			->setCellValue('DE'.$i, '')
			->setCellValue('DF'.$i, '')
			->setCellValue('DG'.$i, '')
			->setCellValue('DH'.$i, '')
			->setCellValue('DI'.$i, '')
			->setCellValue('DJ'.$i, '')
			->setCellValue('DK'.$i, '')
			->setCellValue('DL'.$i, '')
			->setCellValue('DM'.$i, '')
			->setCellValue('DN'.$i, '')
			->setCellValue('DO'.$i, '')
			->setCellValue('DP'.$i, '')
			->setCellValue('DQ'.$i, '')
			->setCellValue('DR'.$i, '')
			->setCellValue('DS'.$i, '')
			->setCellValue('DT'.$i, '')
			->setCellValue('DU'.$i, '')
			->setCellValue('DV'.$i, '')
			->setCellValue('DW'.$i, '')
			->setCellValue('DX'.$i, '')
			->setCellValue('DY'.$i, '')
			->setCellValue('DZ'.$i, '')
			->setCellValue('EA'.$i, '')
			->setCellValue('EB'.$i, '')
			->setCellValue('EC'.$i, '')
			->setCellValue('ED'.$i, '')
			->setCellValue('EE'.$i, '')
			->setCellValue('EF'.$i, '')
			->setCellValue('EG'.$i, '')
			->setCellValue('EH'.$i, '')
			->setCellValue('EI'.$i, '')
			->setCellValue('EJ'.$i, '')
			->setCellValue('EK'.$i, '')
			->setCellValue('EL'.$i, '')
			->setCellValue('EM'.$i, '')
			->setCellValue('EN'.$i, '')
			->setCellValue('EO'.$i, '')
			->setCellValue('EP'.$i, '')
			->setCellValue('EQ'.$i, '')
			->setCellValue('ER'.$i, '')
			->setCellValue('ES'.$i, '')
			->setCellValue('ET'.$i, '')
			->setCellValue('EU'.$i, '')
			->setCellValue('EV'.$i, '')
			->setCellValue('EW'.$i, '')
			->setCellValue('EX'.$i, '')
			->setCellValue('EY'.$i, '')
			->setCellValue('EZ'.$i, '')
			->setCellValue('FA'.$i, '')
			->setCellValue('FB'.$i, '')
			->setCellValue('FC'.$i, '');
		}
      $i++;
	 	
		 }
		$codigo=$registro['amazonsku']; 
		if($tip=="G")
		{
       $objPHPExcel->setActiveSheetIndex($o)
            ->setCellValue('A'.$i, $codigo)
			->setCellValue('B'.$i, $identificador)
			->setCellValue('C'.$i, $tipoIdentificador)
			->setCellValue('D'.$i, $registro['prodname'])
			->setCellValue('E'.$i, $registro['marca'])
			->setCellValue('F'.$i, $registro['manuf'])
			->setCellValue('G'.$i, $registro['prodname'])
			->setCellValue('H'.$i, ""/*categoria homologada*/)
			->setCellValue('I'.$i, ""/*subcategoria homologada*/)
			->setCellValue('J'.$i, $update)
			->setCellValue('K'.$i, '1')
			->setCellValue('L'.$i, $precio)
			->setCellValue('N'.$i, "USD")
			->setCellValue('O'.$i, "0")
			->setCellValue('AM'.$i, $registro['prodname'])
			->setCellValue('BH'.$i, $imagenB)
			->setCellValue('BI'.$i, $imagen1)
			->setCellValue('BJ'.$i, $imagen2)
			->setCellValue('BK'.$i, $imagen3)
			->setCellValue('BL'.$i, $imagen4)
			->setCellValue('BM'.$i, $imagen5)
			->setCellValue('BN'.$i, $imagen6)
			->setCellValue('BO'.$i, $imagen7)
			->setCellValue('BP'.$i, $imagen8)
			->setCellValue('BX'.$i, 'Chinld')
			->setCellValue('BY'.$i, $registro['mastersku'])
			->setCellValue('BZ'.$i, 'Variation')
			->setCellValue('CA'.$i, 'SizeName')
			->setCellValue('CN'.$i, 'Pack of '.$registro['unitbundle'])
			->setCellValue('CX'.$i, '1')
			->setCellValue('CY'.$i, 'Count');
		}
		if($tip=="H")
		{
       $objPHPExcel->setActiveSheetIndex($o)
            ->setCellValue('A'.$i, $codigo)
			->setCellValue('B'.$i, $identificador)
			->setCellValue('C'.$i, $tipoIdentificador)
			->setCellValue('D'.$i, $registro['prodname'])
			->setCellValue('E'.$i, $registro['marca'])
			->setCellValue('F'.$i, $registro['manuf'])
			->setCellValue('G'.$i, $registro['prodname'])
			->setCellValue('H'.$i, ""/*categoria homologada*/)
			->setCellValue('I'.$i, ""/*subcategoria homologada*/)
			->setCellValue('J'.$i, $update)
			->setCellValue('K'.$i, '1')
			->setCellValue('L'.$i, $precio)
			->setCellValue('M'.$i, "")
			->setCellValue('N'.$i, "USD")
			->setCellValue('O'.$i, "0")
			->setCellValue('P'.$i, "")
			->setCellValue('Q'.$i, "")
			->setCellValue('R'.$i, "")
			->setCellValue('S'.$i, "")
			->setCellValue('T'.$i, "")
			->setCellValue('U'.$i, "")
			->setCellValue('V'.$i, "")
			->setCellValue('W'.$i, "")
			->setCellValue('X'.$i, "")
			->setCellValue('Y'.$i, "")
			->setCellValue('Z'.$i, "")
			->setCellValue('AA'.$i, "")
			->setCellValue('AB'.$i, "")
			->setCellValue('AC'.$i, "")
			->setCellValue('AD'.$i, "")
			->setCellValue('AE'.$i, "")
			->setCellValue('AF'.$i, "")
			->setCellValue('AG'.$i, "")
			->setCellValue('AH'.$i, "")
			->setCellValue('AI'.$i, "")
			->setCellValue('AJ'.$i, "")
			->setCellValue('AK'.$i, "")
			->setCellValue('AL'.$i, "")
			->setCellValue('AM'.$i, $registro['prodname'])
			->setCellValue('AN'.$i, '')
			->setCellValue('AO'.$i, '')
			->setCellValue('AP'.$i, '')
			->setCellValue('AQ'.$i, '')
			->setCellValue('AR'.$i, '')
			->setCellValue('AS'.$i, '')
			->setCellValue('AT'.$i, '')
			->setCellValue('AU'.$i, '')
			->setCellValue('AV'.$i, '')
			->setCellValue('AW'.$i, '')
			->setCellValue('AX'.$i, '')
			->setCellValue('AY'.$i, '')
			->setCellValue('AZ'.$i, '')
			->setCellValue('BA'.$i, '')
			->setCellValue('BB'.$i, '')
			->setCellValue('BC'.$i, '')
			->setCellValue('BD'.$i, '')
			->setCellValue('BE'.$i, '')
			->setCellValue('BF'.$i, '')
			->setCellValue('BG'.$i, '')
			->setCellValue('BH'.$i, $imagenB)
			->setCellValue('BI'.$i, $imagen1)
			->setCellValue('BJ'.$i, $imagen2)
			->setCellValue('BK'.$i, $imagen3)
			->setCellValue('BL'.$i, $imagen4)
			->setCellValue('BM'.$i, $imagen5)
			->setCellValue('BN'.$i, $imagen6)
			->setCellValue('BO'.$i, $imagen7)
			->setCellValue('BP'.$i, $imagen8)
			->setCellValue('BQ'.$i, '')
			->setCellValue('BR'.$i, '')
			->setCellValue('BS'.$i, '')
			->setCellValue('BT'.$i, '')
			->setCellValue('BU'.$i, '')
			->setCellValue('BV'.$i, '')
			->setCellValue('BW'.$i, '')
			->setCellValue('BX'.$i, 'Chinld')
			->setCellValue('BY'.$i, $registro['mastersku'])
			->setCellValue('BZ'.$i, 'Variation')
			->setCellValue('CA'.$i, 'SizeName')
			->setCellValue('CB'.$i, '')
			->setCellValue('CC'.$i, '')
			->setCellValue('CD'.$i, '')
			->setCellValue('CE'.$i, '')
			->setCellValue('CF'.$i, '')
			->setCellValue('CG'.$i, '')
			->setCellValue('CH'.$i, '')
			->setCellValue('CI'.$i, '')
			->setCellValue('CJ'.$i, '')
			->setCellValue('CK'.$i, '')
			->setCellValue('CL'.$i, '')
			->setCellValue('CM'.$i, '')
			->setCellValue('CN'.$i, 'Pack of '.$registro['unitbundle'])
			->setCellValue('CO'.$i, '')
			->setCellValue('CP'.$i, '')
			->setCellValue('CQ'.$i, '')
			->setCellValue('CR'.$i, '')
			->setCellValue('CS'.$i, '')
			->setCellValue('CT'.$i, '')
			->setCellValue('CU'.$i, '')
			->setCellValue('CV'.$i, '')
			->setCellValue('CW'.$i, '')
			->setCellValue('CX'.$i, '1')
			->setCellValue('CY'.$i, 'Count')
			->setCellValue('CZ'.$i, '')
			->setCellValue('DA'.$i, '')
			->setCellValue('DB'.$i, '')
			->setCellValue('DC'.$i, '')
			->setCellValue('DD'.$i, '')
			->setCellValue('DE'.$i, '')
			->setCellValue('DF'.$i, '')
			->setCellValue('DG'.$i, '')
			->setCellValue('DH'.$i, '')
			->setCellValue('DI'.$i, '')
			->setCellValue('DJ'.$i, '')
			->setCellValue('DK'.$i, '')
			->setCellValue('DL'.$i, '')
			->setCellValue('DM'.$i, '')
			->setCellValue('DN'.$i, '')
			->setCellValue('DO'.$i, '')
			->setCellValue('DP'.$i, '')
			->setCellValue('DQ'.$i, '')
			->setCellValue('DR'.$i, '')
			->setCellValue('DS'.$i, '')
			->setCellValue('DT'.$i, '')
			->setCellValue('DU'.$i, '')
			->setCellValue('DV'.$i, '')
			->setCellValue('DW'.$i, '')
			->setCellValue('DX'.$i, '')
			->setCellValue('DY'.$i, '')
			->setCellValue('DZ'.$i, '')
			->setCellValue('EA'.$i, '')
			->setCellValue('EB'.$i, '')
			->setCellValue('EC'.$i, '')
			->setCellValue('ED'.$i, '')
			->setCellValue('EE'.$i, '')
			->setCellValue('EF'.$i, '')
			->setCellValue('EG'.$i, '')
			->setCellValue('EH'.$i, '')
			->setCellValue('EI'.$i, '')
			->setCellValue('EJ'.$i, '')
			->setCellValue('EK'.$i, '')
			->setCellValue('EL'.$i, '')
			->setCellValue('EM'.$i, '')
			->setCellValue('EN'.$i, '')
			->setCellValue('EO'.$i, '')
			->setCellValue('EP'.$i, '')
			->setCellValue('EQ'.$i, '')
			->setCellValue('ER'.$i, '')
			->setCellValue('ES'.$i, '')
			->setCellValue('ET'.$i, '')
			->setCellValue('EU'.$i, '')
			->setCellValue('EV'.$i, '')
			->setCellValue('EW'.$i, '')
			->setCellValue('EX'.$i, '')
			->setCellValue('EY'.$i, '')
			->setCellValue('EZ'.$i, '')
			->setCellValue('FA'.$i, '')
			->setCellValue('FB'.$i, '')
			->setCellValue('FC'.$i, '');
		}
      $i++;
      
   }
   /*
   $estiloTituloColumnas = array(
    'font' => array(
        		'name'  => 'Arial',
        		'bold'  => true,
        		'color' => array(
            					'rgb' => 'FFFFFF'
        						)
    				),
    'fill' => array(
        			'type'=> PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,
  					'rotation'=> 90,
        			'startcolor' => array(
            								'rgb' => '000000'
        								),
        			'endcolor' => array(
            							'argb' => 'FF431a5d'
        								)
    				),
    'borders' => array(
        				'top' => array(
            							'style' => PHPExcel_Style_Border::BORDER_MEDIUM ,
            							'color' => array(
                										'rgb' => '143860'
            												)
        								),
        				'bottom' => array(
            							'style' => PHPExcel_Style_Border::BORDER_MEDIUM ,
            							'color' => array(
                										'rgb' => '143860'
            											)
        									),
						'left' => array(
            							'style' => PHPExcel_Style_Border::BORDER_MEDIUM ,
            							'color' => array(
                										'rgb' => '143860'
            												)
        								),
						'right' => array(
            							'style' => PHPExcel_Style_Border::BORDER_MEDIUM ,
            							'color' => array(
                										'rgb' => '143860'
            												)
        								),
    					),
    'alignment' =>  array(
        					'horizontal'=> PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        					'vertical'  => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        					'wrap'      => TRUE
    						)
	);

	$estiloInformacion = new PHPExcel_Style();
	$estiloInformacion->applyFromArray( array(
    	'font' => array(
        	'name'  => 'Arial',
        	'color' => array(
            				'rgb' => '000000'
        					)
    				),
    	'fill' => array(
  					'type'  => PHPExcel_Style_Fill::FILL_SOLID
  						),
    	'alignment' =>  array(
        					'horizontal'=> PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        					'vertical'  => PHPExcel_Style_Alignment::VERTICAL_CENTER
    						),
    	'borders' => array(
        			'left' => array(
            					'style' => PHPExcel_Style_Border::BORDER_THIN 
        							),
					'right' => array(
            					'style' => PHPExcel_Style_Border::BORDER_THIN 
        							),
					'top' => array(
            					'style' => PHPExcel_Style_Border::BORDER_THIN 
        							),
					'bottom' => array(
            					'style' => PHPExcel_Style_Border::BORDER_THIN 
        							)
    					),
					
				));
   
   $objPHPExcel->getActiveSheet()->getStyle('A2:AM2')->applyFromArray($estiloTituloColumnas);
   $objPHPExcel->getActiveSheet()->getColumnDimension("A")->setAutoSize(true);
   $objPHPExcel->getActiveSheet()->getColumnDimension("B")->setAutoSize(true);
   $objPHPExcel->getActiveSheet()->getColumnDimension("C")->setAutoSize(true);
   $objPHPExcel->getActiveSheet()->getColumnDimension("D")->setAutoSize(true);
   $objPHPExcel->getActiveSheet()->getColumnDimension("E")->setAutoSize(true);
   $objPHPExcel->getActiveSheet()->getColumnDimension("F")->setAutoSize(true);
   $objPHPExcel->getActiveSheet()->getColumnDimension("G")->setAutoSize(true);
   $objPHPExcel->getActiveSheet()->getColumnDimension("H")->setAutoSize(true);
   $objPHPExcel->getActiveSheet()->getColumnDimension("I")->setAutoSize(true);
   $objPHPExcel->getActiveSheet()->getColumnDimension("J")->setAutoSize(true);
   $objPHPExcel->getActiveSheet()->getColumnDimension("K")->setAutoSize(true);
   $objPHPExcel->getActiveSheet()->getColumnDimension("L")->setAutoSize(true);
   $objPHPExcel->getActiveSheet()->getColumnDimension("M")->setAutoSize(true);
   $objPHPExcel->getActiveSheet()->getColumnDimension("N")->setAutoSize(true);
   $objPHPExcel->getActiveSheet()->getColumnDimension("O")->setAutoSize(true);
   $objPHPExcel->getActiveSheet()->getColumnDimension("P")->setAutoSize(true);
   $objPHPExcel->getActiveSheet()->getColumnDimension("Q")->setAutoSize(true);
   $objPHPExcel->getActiveSheet()->getColumnDimension("R")->setAutoSize(true);
   $objPHPExcel->getActiveSheet()->getColumnDimension("S")->setAutoSize(true);
   $objPHPExcel->getActiveSheet()->getColumnDimension("T")->setAutoSize(true);
   $objPHPExcel->getActiveSheet()->getColumnDimension("U")->setAutoSize(true);
   $objPHPExcel->getActiveSheet()->getColumnDimension("V")->setAutoSize(true);
   $objPHPExcel->getActiveSheet()->getColumnDimension("W")->setAutoSize(true);
   $objPHPExcel->getActiveSheet()->getColumnDimension("X")->setAutoSize(true);
   $objPHPExcel->getActiveSheet()->getColumnDimension("Y")->setAutoSize(true);
   $objPHPExcel->getActiveSheet()->getColumnDimension("Z")->setAutoSize(true);
   $objPHPExcel->getActiveSheet()->getColumnDimension("AA")->setAutoSize(true);
   $objPHPExcel->getActiveSheet()->getColumnDimension("AB")->setAutoSize(true);
   $objPHPExcel->getActiveSheet()->getColumnDimension("AC")->setAutoSize(true);
   $objPHPExcel->getActiveSheet()->getColumnDimension("AD")->setAutoSize(true);
   $objPHPExcel->getActiveSheet()->getColumnDimension("AE")->setAutoSize(true);
   $objPHPExcel->getActiveSheet()->getColumnDimension("AF")->setAutoSize(true);
   $objPHPExcel->getActiveSheet()->getColumnDimension("AG")->setAutoSize(true);
   $objPHPExcel->getActiveSheet()->getColumnDimension("AH")->setAutoSize(true);
   $objPHPExcel->getActiveSheet()->getColumnDimension("AI")->setAutoSize(true);
   $objPHPExcel->getActiveSheet()->getColumnDimension("AJ")->setAutoSize(true);
   $objPHPExcel->getActiveSheet()->getColumnDimension("AK")->setAutoSize(true);
   $objPHPExcel->getActiveSheet()->getColumnDimension("AL")->setAutoSize(true);
   $objPHPExcel->getActiveSheet()->getColumnDimension("AM")->setAutoSize(true);
   $objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion, "A3:AM".($i-1));
   /*
   $objPHPExcel->getActiveSheet() ->getStyle('G4:K'.$i) ->getNumberFormat() ->setFormatCode( '_-$* #,##0.00_-;-Q* #,##0.00_-;_-Q* "-"??_-;_-@_-' ); 
   $objPHPExcel->getActiveSheet() ->getStyle('N4:O'.$i) ->getNumberFormat() ->setFormatCode( '_-$* #,##0.00_-;-Q* #,##0.00_-;_-Q* "-"??_-;_-@_-' ); 
   $objPHPExcel->getActiveSheet() ->getStyle('R4:T'.$i) ->getNumberFormat() ->setFormatCode( '_-$* #,##0.00_-;-Q* #,##0.00_-;_-Q* "-"??_-;_-@_-' ); 
   $objPHPExcel->getActiveSheet() ->getStyle('V4:W'.$i) ->getNumberFormat() ->setFormatCode( '_-$* #,##0.00_-;-Q* #,##0.00_-;_-Q* "-"??_-;_-@_-' ); 
   $objPHPExcel->getActiveSheet() ->getStyle('Z4:AA'.$i) ->getNumberFormat() ->setFormatCode( '_-$* #,##0.00_-;-Q* #,##0.00_-;_-Q* "-"??_-;_-@_-' ); 
   $objPHPExcel->getActiveSheet() ->getStyle('AC4:AC'.$i) ->getNumberFormat() ->setFormatCode( '_-$* #,##0.00_-;-Q* #,##0.00_-;_-Q* "-"??_-;_-@_-' ); 
   $objPHPExcel->getActiveSheet() ->getStyle('R4:T'.$i) ->getNumberFormat() ->setFormatCode( '_-$* #,##0.00_-;-Q* #,##0.00_-;_-Q* "-"??_-;_-@_-' ); */
}
header('Content-Type: application/vnd.ms-excel');
if($tip=="H")
		{
header('Content-Disposition: attachment;filename="PlantillaAmazonMedicina.xlsx"');

		}
		
if($tip=="G")
		{
header('Content-Disposition: attachment;filename="PlantillaAmazonFoodBeverage.xlsx"');

		}
		
header('Cache-Control: max-age=0');

$objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
$objWriter->save('php://output');
exit;
mysql_close ();


?>
