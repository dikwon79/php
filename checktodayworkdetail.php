<?
	  if ($tabidinfo =="data"){
?>
<table id="table" class="table table-bordered table-hover table-striped" style="table-layout: fixed">  
											<thead>  
											<tr>  
												<th>회사명</th> 
												<th>거래처</th> 
												<th>작업날짜</th> 
												<th>맵핑코드</th> 
												<th style=width:300px>품목명</th>
												<th>수량</th>
												<th>단위</th>
												<th>센터</th>
												<th>차수</th>
												<th>업장명</th>
												<th>원수량</th>
												<th>원단위</th>
												
												
											</tr>  
											</thead>  
													   
											<?php  

										
											//$stmt = $con->prepare("SELECT a.itemcode,a.itemname,a.lek,a.inventory,B.outstock,B.nowstock  FROM iteminfo a,(select * from nowinven b)B where a.itemcode = B.itemcode AND B.idate=:var_idate");
											//0717$sql = "SELECT y.companyname,y.idate,if(a.mappingcode is not null,if(a.mappingcode='',y.itemcode,a.mappingcode),y.itemcode) as 'code',y.itemname,if(y.unit='BOX',y.chaivalue*a.packsu,y.chaivalue) AS 'surang','EA' as 'danwi',y.center,y.chasu,y.customer,y.chaivalue,y.unit FROM (SELECT * FROM iteminfo)a RIGHT JOIN (SELECT companyname,idate,itemcode,itemname,chaivalue,unit,center,chasu,customer FROM labelmain where idate=:var_idate)y ON a.itemcode = y.itemcode";
											
											$sql = "SELECT h.companyname,h.georae,h.idate,h.code,h.itemname,h.surang,h.danwi,b.printinfo,h.center,h.chasu,h.customer,h.chaivalue,h.unit 
											from(SELECT y.companyname,if(a.georae is NULL,'미등록', a.georae) AS 'georae',y.idate,
											if(a.mappingcode IS NOT NULL,if(a.mappingcode='',y.itemcode,a.mappingcode),y.itemcode) AS 'code',
											if(a.itemname is NULL,y.itemname,a.itemname) AS 'itemname',if(a.itemname is NULL, chaivalue, 
											if(y.unit='BOX',y.chaivalue*a.packsu,y.chaivalue)) AS 'surang',if(a.itemname IS NULL, y.unit, 'EA') AS 'danwi',
											y.center,y.chasu,y.customer,y.chaivalue,y.unit FROM (SELECT * FROM iteminfo)a 
											RIGHT JOIN (SELECT companyname,idate,itemcode,itemname,chaivalue,unit,center,chasu,customer FROM labelmain 
											WHERE idate=:var_idate)y ON a.itemcode = y.itemcode)h 
											LEFT JOIN print_info b ON h.center = CONCAT(b.center,' / ',b.centername)";
											

											
											/*
											$sql = "SELECT y.companyname,y.idate,if(a.mappingcode IS NOT NULL,if(a.mappingcode='',y.itemcode,a.mappingcode),y.itemcode) AS 'code',y.itemname,if(y.unit='BOX',y.chaivalue*a.packsu,y.chaivalue) AS 'surang','EA' AS 'danwi',y.center,y.chasu,y.customer,y.chaivalue,y.unit
													FROM (
													SELECT *
													FROM iteminfo)a
													RIGHT JOIN (
													SELECT TYPE, companyname,idate,itemcode,itemname,sum(chaivalue) AS 'chaivalue',unit,center,chasu,'센터별합' AS 'customer'
													FROM labelmain
													WHERE idate=:var_idate AND TYPE ='신규' GROUP BY center,itemcode,unit,chasu 
													UNION ALL
													SELECT TYPE, companyname,idate,itemcode,itemname,chaivalue,unit,center,chasu,customer
													FROM labelmain
													WHERE idate=:var_idate AND TYPE !='신규')y ON a.itemcode = y.itemcode";
											
											*/
											//$sql = "SELECT idate,itemcode,itemname,chaivalue,unit,center,chasu,customer,bar2 FROM labelmain where idate=:var_idate";
											
										    //echo $sql;   
												   //SELECT a.itemcode,a.itemname,a.lek,a.inventory,B.outstock,B.nowstock  FROM iteminfo a,(select * from nowinven b)B where a.itemcode = B.itemcode AND B.idate=:var_idate");
											
											//$sql = "SELECT y.companyname,y.idate,if(a.mappingcode IS NOT NULL,if(a.mappingcode='',y.itemcode,a.mappingcode),y.itemcode) AS 'code',y.itemname,sum(if(y.unit='BOX',if(packsu is NULL, y.chaivalue, y.chaivalue*a.packsu),y.chaivalue)) AS 'surang','EA' AS 'danwi',y.center,y.chasu,y.customer,y.chaivalue,y.unit FROM (
                                                  //  SELECT * FROM iteminfo)a RIGHT JOIN (SELECT companyname,idate,itemcode,itemname,chaivalue,unit,center,chasu,customer FROM labelmain WHERE idate=:var_idate)y ON a.itemcode = y.itemcode GROUP BY y.chasu,code,y.center"; 


											$stmt = $con->prepare($sql);

											$stmt->bindParam(':var_idate',$value);


											
											$stmt->execute();

											if ($stmt->rowCount() > 0)
												{
													while($row=$stmt->fetch(PDO::FETCH_ASSOC))
												{
												extract($row);
										   
											if ($username != 'admin'){
											?>  
												<tr>  
												<td><?php echo $companyname; ?></td>
												<td><?php echo $georae; ?></td>
												<td><?php echo $idate; ?></td>
												<td><?php echo $code; ?></td>
											
												<td><?php echo $itemname;  ?></td>
												<td><?php echo $surang;  ?></td> 
												<td><?php echo $danwi; ?></td>
												
												<td><?php echo '1'.$printinfo; ?></td>
												<td><?php echo $chasu; ?></td>
												<td><?php echo $customer; ?></td>
												<td><?php echo $chaivalue; ?></td>
												<td><?php echo $unit; ?></td>
												
												</tr>
											
											<?php
												}
													}
												 }
											
											?>  
											</table>
											<? 

                                               }//tabinfo
												?>