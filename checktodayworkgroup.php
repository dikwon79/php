<?

  
                                              if ($tabidinfo =="second"){
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


												$sql = "SELECT h.companyname,h.georae,h.idate,h.code,h.itemname,sum(h.surang) as 'surang' ,h.danwi,b.printinfo,h.center,h.chasu,h.customer,sum(h.chaivalue) as 'chaivalue',h.unit 
											from(SELECT y.companyname,if(a.georae is NULL,'미등록', a.georae) AS 'georae',y.idate,
											if(a.mappingcode IS NOT NULL,if(a.mappingcode='',y.itemcode,a.mappingcode),y.itemcode) AS 'code',
											if(a.itemname is NULL,y.itemname,a.itemname) AS 'itemname',if(a.itemname is NULL, chaivalue, 
											if(y.unit='BOX',y.chaivalue*a.packsu,y.chaivalue)) AS 'surang',if(a.itemname IS NULL, y.unit, 'EA') AS 'danwi',
											y.center,y.chasu,y.customer,y.chaivalue,y.unit FROM (SELECT * FROM iteminfo)a 
											RIGHT JOIN (SELECT companyname,idate,itemcode,itemname,chaivalue,unit,center,chasu,customer FROM labelmain 
											WHERE idate=:var_idate)y ON a.itemcode = y.itemcode)h 
											LEFT JOIN print_info b ON h.center = CONCAT(b.center,' / ',b.centername) GROUP BY h.code,b.printinfo order by h.georae,h.itemname,h.center asc";
											
										   

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
												<td><?php echo '합산'; ?></td>
												<td><?php echo '합산'; ?></td>
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