<?php 
    session_start();
    
    // point 9
    $cookie_name = "user";
    $cookie_value = "Test User";
    setcookie($cookie_name, $cookie_value, time() + (86400*30), '/','localhost', 0)
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="20">
    <title>Calculator</title>
    
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  
<style>
  .li_containers{
    width: 52%;
    float: left;
  }
  .listitems { 
      width: 150px; 
      height: 150px; 
      padding: 0.5em; 
      float: left; 
      margin: 10px 10px 10px 0;
      border: 1px solid black;
      font-weight: normal;
   }
  #droppable { 
    width:   550px; 
    height:  550px; 
    padding: 0.5em; 
    float:   right; 
    margin:  10px;
    cursor:  pointer;
   }
  </style>
</head>
<body>
    <div style="float: right;">
        <a  href="../logout.php">Logout</a>
    </div>
    
    <!-- POINT 2 - Search Engine Website -->
    <div class="searchEngine">
        <form action="" method="GET" target="_blank">
            <input type="url" name="url" placeholder="Enter URL">
            <button>GO</button>
        </form>
    </div>
    
    <?php
         if(isset($_GET['url'])) 
         {
            $url = $_GET['url'];
            
            ?>
            <script>
                window.location.href = "<?php echo $url;?>";
            </script>
            <?php
         }
    ?>
    
    <!-- POINT 3 - Calculator -->
    <?php
    ini_set('display_errors',0);

    if( isset( $_REQUEST['calculate'] ))
    {
    $operator=$_REQUEST['operator'];
    $n1 = $_REQUEST['first_value'];
    $n2 = $_REQUEST['second_value'];

    if($operator=="+")
    {
    $res= $n1+$n2;
    }
    if($operator=="-")
    {
    $res= $n1-$n2;
    }
    if($operator=="*")
    {
    $res =$n1*$n2;
    }
    if($operator=="/")
    {
    $res= $n1/$n2;
    }

    if($_REQUEST['first_value']==NULL || $_REQUEST['second_value']==NULL)
    {
    echo "<script language=javascript> alert(\"Please Enter Correct values.\");</script>";
    }
    }
    ?>

    <form>
    <table style="border:groove #00FF99">

    <tr>
    <td style="background-color:turquoise; color:black; font-family:'Times New Roman'">Enter Number</td>
    <td colspan="1">
    <input name="first_value" type="text" style="color:red"/></td>
    </tr>

    <tr>
    <td style="color:red; font-family:'Times New Roman'">Select Operator</td>
    <td>
    <select name="operator" style="width: 63px">
    <option>+</option>
    <option>-</option>
    <option>*</option>
    <option>/</option>
    </select></td>
    </tr>

    <tr>
    <td style="background-color:turquoise; color:black; font-family:'Times New Roman'">Enter Number</td>
    <td class="auto-style5">
    <input name="second_value" type="text"  style="color:red"/></td> 
    </tr>

    <tr>
    <td></td>
    <td><input type="submit" name="calculate" value="Calculate" style="color:wheat;background-color:rosybrown" /></td>	 
    </tr>

    <tr>
    <td style="background-color:turquoise;color:black">Output = </td>
    <td style="color:darkblue"><?php echo $res;?></td>
    </tr>	

    </table>
    </form>
    
<!-- POINT 4 - Todo LIST -->
<?php
    require_once("../connection.php");
    
    if(mysqli_connect_error())
    {
        die('Connection Error('. mysqli_connect_errno().')'. mysqli_connect_error());
    }
    else
    {
        $SLTINC = "SELECT id, name, detail, is_completed FROM listitems WHERE is_completed = 'no' ORDER BY id desc";
        $result = mysqli_query($conn, $SLTINC);
        
        $incompleteItems   = mysqli_fetch_all($result,MYSQLI_ASSOC);
        
        $SLTCPT = "SELECT id, name, detail, is_completed FROM listitems WHERE is_completed = 'yes' ORDER BY id desc";
        $cptresult = mysqli_query($conn, $SLTCPT);
        
        $completeItems   = mysqli_fetch_all($cptresult,MYSQLI_ASSOC);
        
        //Free result set
        mysqli_free_result($cptresult);
        mysqli_free_result($result);
        
        mysqli_close($conn);
    }
?>

<div class="li_containers">
 
 <?php foreach ($incompleteItems as $key => $item) { ?>
 
   <div class="ui-widget-content listitems" data-itemid=<?php echo $item['id'] ?> >
 
     <p><strong><?php echo $item['name'] ?></strong></p>
 
     <hr />
 
     <p><?php echo $item['detail'] ?></p>
 
   </div>
 
 <?php } ?> 
  
</div>
<div id="droppable" class="ui-widget-header">
  <?php foreach ($completeItems as $key => $citem) { ?>
    <div class="listitems" >
      <p><strong><?php echo $citem['name'] ?></strong></p>
      <hr />
      <p><?php echo $citem['detail'] ?></p>
    </div>
  <?php } ?>
</div>
 <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
 
 <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  
 <script>
  $( function() {
    $( ".listitems" ).draggable();
    $( "#droppable" ).droppable({
 
      drop: function( event, ui ) {
         
          $(this).addClass( "ui-state-highlight" );
 
          var itemid = ui.draggable.attr('data-itemid')
          
          $.ajax({
             method: "POST",
           
             url: "update_item_status.php",
             data:{'itemid': itemid}, 
          }).done(function( data ) {
             var result = $.parseJSON(data);
           
           });
         }
      });
  });
</script>

<!-- POINT 5  -->
<?php

    // Project Name
    $proj = $_SERVER["SCRIPT_NAME"];
    $break = explode('/', $proj);
    $pfile = $break[count($break) - 1];
    
    //script name
    $file = $_SERVER["SCRIPT_NAME"];
    
    //Printing
    echo $pfile. "<br />";
    echo $file. "<br />";
?>

<!-- POINT 6 - Determine Time -->
<?php 
    $time = microtime();
    $time = explode(' ', $time);
    $time = $time[1] + $time[0];
    $finish = $time;
    $total_time = round(($finish - $start), 4);
    echo 'Page Requested time is '.$total_time.' seconds';
?>

<!-- POINT 7 - Website Counter on refresh -->
<?php
    $_SESSION['count'] = 0;

    if(isset($_SESSION['count']))
    {
        $_SESSION['count'] = $_SESSION['count'] + 1;
        echo "<div class=\page-counter>Count: {$_SESSION['count']}\n</div>";
    }
    else 
    {
        $_SESSION['count'] = 0;    
    }
?>

<!-- POINT 8 -->
<?php
    $countvisit = 1;
    
    if(isset($_COOKIE['countvisit']))
    {
        $countvisit = $_COOKIE['countvisit'];
        $countvisit++;
    }
    
    setcookie('countvisit', $countvisit);
    echo "Visit Counter: ".$countvisit. "<br />";
?>

<!-- POINT 9 -->
<?php 
if(!isset($_COOKIE[$cookie_name])) 
{
    echo "Cookie named '". $cookie_name. "' is not set";
}
else 
{
    echo "Cookie '".$_COOKIE[$cookie_name]. "' <br />";
}
?>
</body>
</html>