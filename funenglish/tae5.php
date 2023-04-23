<html>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8;">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1;">
<head>
	<title>made by Sam</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">


<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<style>
   
.gallery-title
{
    font-size: 36px;
    color: #42B32F;
    text-align: center;
    font-weight: 500;
    margin-bottom: 70px;
}
.gallery-title:after {
    content: "";
    position: absolute;
    width: 7.5%;
    left: 46.5%;
    height: 45px;
    border-bottom: 1px solid #5e5e5e;
}
.filter-button
{
    font-size: 18px;
    border: 1px solid #42B32F;
    border-radius: 5px;
    text-align: center;
    color: #42B32F;
    margin-bottom: 30px;

}
.filter-button:hover
{
    font-size: 18px;
    border: 1px solid #42B32F;
    border-radius: 5px;
    text-align: center;
    color: #ffffff;
    background-color: #42B32F;

}
.btn-default:active .filter-button:active
{
    background-color: #42B32F;
    color: white;
}

.port-image
{
    width: 100%;
}

.gallery_product
{
    margin-bottom: 30px;
}



</style>
<script>
    $(document).ready(function(){

    $(".filter-button").click(function(){
        var value = $(this).attr('data-filter');
        
        if(value == "all")
        {
            //$('.filter').removeClass('hidden');
            $('.filter').show('1000');
        }
        else
        {
//            $('.filter[filter-item="'+value+'"]').removeClass('hidden');
//            $(".filter").not('.filter[filter-item="'+value+'"]').addClass('hidden');
            $(".filter").not('.'+value).hide('3000');
            $('.filter').filter('.'+value).show('3000');
            
        }
    });
    
    if ($(".filter-button").removeClass("active")) {
	$(this).removeClass("active");
	}
	$(this).addClass("active");

	});
 
    function openpage(codeI)
	{
        window.open('tae5song.php?code='+codeI,'_self','location=no, directories=no,resizable=no,status=no,toolbar=no,menubar=no, width=300,height=400,left=0, top=0, scrollbars=yes');
		//window.location.href = "detail_item.php?code="+codeI;
		//alert(codeI);

	}
</script>
<!------ Include the above in your HEAD tag ---------->
<?
  $connect = mysqli_connect("localhost","dikwon79","ab0612abcD!@","dikwon79");
 
  $sql = "SELECT * FROM tbl_funenglish group by youtubeid order by id asc";
  $result = mysqli_query($connect,$sql);

  $total = mysqli_num_rows($result);
 
       
       

  
?>
 <div class="container">
        <div class="row">
        <div class="gallery col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <h1 class="gallery-title">2021-07 :Pop Songs with David</h1>
			<h4>Just Click on what you want to hear<h4>
        </div>

        <div align="center">
            <button class="btn btn-default filter-button" data-filter="all">All</button>
            <button class="btn btn-default filter-button" data-filter="news">Presentaion songs</button>
			<button class="btn btn-default filter-button" data-filter="bbc">David songs</button>
            <button class="btn btn-default filter-button" data-filter="animation">best songs</button>
           
        </div>
        <br/>
            <?
			for($i=0; $i<$total; $i++){
				 $row = mysqli_fetch_assoc($result); 

            ?>
		    <div class="gallery_product col-lg-4 col-md-4 col-sm-4 col-xs-6 filter <? echo $row[sortof]?>">
                <a href="#" onclick="openpage('<? echo $row[youtubeid]; ?>')"><img src="https://img.youtube.com/vi/<? echo $row[youtubeid];?>/0.jpg" class="img-responsive"></a><? echo $row[title]?>
            </div>
		    <?
			}
			
			?>
		
		   
           
           
        </div>
    </div>
</section>
<?

     $result->free();
?>