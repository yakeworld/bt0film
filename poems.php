
<?php
ini_set('display_errors', 'off');
require_once 'mysqlconfig.php';
$conn = new PDO("mysql:host=$host;dbname=$db","$username","$password");
$conn->exec("SET CHARACTER SET utf8");

if(isset($_GET['title'])){
$lib=$_GET['title'];
}
else{
$title="";
}

 
if(isset($_GET['p'])){
$page=$_GET['p'];
}
else{
$page="1";
}



if(isset($_GET['content'])){
$content=$_GET['content'];
}
else{
$content="";
}


if(isset($_GET['author'])){
$author=$_GET['author'];
}
else{
$author="";
}
 

if($page<0)
{
$page=1;
}


$sql="select count(*) from poems where title like '%$title%' and content like '%$content%' and author like '%$author%' ";

print "<hr>$sql<hr>";

$total=$conn->query($sql)->fetchColumn();

print "<hr>total $total<hr>";

$pagesize=20;

$num=($page-1)*$pagesize;
$page_num=$page*pagesize;
$last=$total-$num;
$pageup=$page-1;
$pagedown=$page+1;
$pagetotal=floor($total/$pagesize);

$sql="select * from poems where title like '%$title%' and content like '%$content%' and author like '%$author%' limit $num,$pagesize";


?>


<!doctype html>

<html lang="zh-cmn-Hans" class="ua-windows ua-webkit">



<head>

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

<meta name="renderer" content="webkit">

<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">

<link href="/film/css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />

<link href="/film/css/main.css" rel="stylesheet" type="text/css" media="all" />

<link href="/film/css/custom.3.css" rel="stylesheet" type="text/css" media="all" />

<link href="/film/css/poems.css" rel="stylesheet" type="text/css" />
</head>

<body>

<a id="start"></a>

<div class="nav-container ">



    <div class="bar bar--sm visible-xs">

        <div class="container">

            <div class="row">

                <div class="col-xs-3 col-sm-2">

                    <a href="/">





                    </a>

                </div>

                <div class="col-xs-9 col-sm-10 text-right">

                    <a href="#" class="hamburger-toggle toggled-class" data-toggle-class="#menu2;hidden-xs hidden-sm">

                        <i class="icon icon--sm stack-interface stack-menu"></i>

                    </a>

                </div>

            </div>

        </div>

    </div>



    <nav class="bar bar-2 hidden-xs bar--absolute bar--transparent" id="menu2">

        <div class="container">

            <div class="row">

                <div class="col-md-2 hidden-xs hidden-sm">

                    <div class="bar__module">

                        <a href="/">



                        </a>

                    </div>



                </div>



                <div class="col-md-8">

                    <div class="bar__module">

                        <ul class="menu-horizontal">

                         <li class="dropdown">
                                <a href="/poems.php" target="_blank"><span class="dropdown__trigger">宋词鉴赏</span></a>
                            </li>
                            <li class="dropdown">
                                <a href="/poetry.php" target="_blank"><span class="dropdown__trigger">唐诗鉴赏</span></a>
                            </li>

                            <li>

                                <a href="#" data-notification-link="search-box">

                                    <i class="stack-search"></i>

                                </a>

                            </li>

                        </ul>

                    </div>



                </div>



            </div>



        </div>



    </nav>

    <div class="notification pos-top pos-right search-box bg--semi border--bottom" data-animation="from-top" data-notification-link="search-box">

        <form  method="get" action="/poems.php" name="glb">

            <div class="row">

             <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2 navbar-form">
              <b>词曲名：<b><input type="text" name="title">
              作者：<input type="text" name="author">
              内容：<input type="text" name="content">
              <button lass="form-control" type="submit" id="DoSearch">搜索</button>    
                
                </div>

            </div>

            <!--end of row-->

        </form>

    </div>

</div>



<div></div>










<div class="main-container">


<?php
$result=$conn->query($sql);

foreach ($result as $row) {


print <<<END




<div>
  
        
 <p><b>$row[title]</b></p>
<p class="source">$row[author]</p>
<div class="contson" id="$row[id]">
$row[content]
           
    
</div>

END;





    }



?>





                     


</div>





<?php

print <<<END

 <div class="pagination">

                                                <div class="col-xs-6 text-left hidden-md hidden-lg">

                               <a class="type--fine-print" href="/poems.php?title=$title&content=$content&author=$author&p=$pageup"><< 上一页</a>

                            </div>



                           <div class="col-xs-6 text-right  hidden-md hidden-lg">

                              <a class="type--fine-print" href="/poems.php?title=$title&content=$content&author=$author&p=$pagedown">下一页 >></a>

                          </div>





                   </div>

 <div class="text-center hidden-sm hidden-xs">

                        <ul class='tsc_pagination tsc_paginationA tsc_paginationA06'>

                            <li><a class="prev" href="/poems.php?title=$title&content=$content&author=$author&p=1">&nbsp;</a></li>


END;



$start=$page;

if($start>2)
{
$start=$start-2;
}



$pageout=$pagetotal;
$pagemax=$pagetotal+1;

if($pageout-$start>10)
{
$pageout=10+$start;
}


for ($i=$start;$i<$pageout;$i++)

{

if($i==$page)
{

print <<<END

<li class="active"><span class="current">$i</span></li>

END;

}

else
{

print <<<END

<li><a class="num" href="/poems.php?title=$title&content=$content&author=$author&p=$i">$i</a></li>

END;

}
}

print <<<END

<li><a class="end" href="/poems.php?title=$title&content=$content&author=$author&p=$pagemax">...$pagemax</a></li>

                        </ul>

                    </div>




END;



?>

<!--<div class="loader"></div>-->

<script src="/film/js/jquery.min.js"></script>

<script src="/film/js/jquery.lazyload.js"></script>

<script>

    $("img.lazy").lazyload({

        threshold : 200

    });



    $(".tabs li:first").addClass("active")



    $(".tabs-content li:first").addClass("active")



</script>

<script src="/film/js/bundle.min.js"></script>



<script>

    $(document).ready(function () {

        $("[class='text-center height-60']").delay(2200).animate({height: "40vh",paddingBottom:"0.6em"})

    })

</script>

</body>





</html>


