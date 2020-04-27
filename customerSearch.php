<?php
require_once 'config.php';
require_once 'db.php';

$db = connect(DB_HOST, DB_NAME, DB_USERNAME, DB_PASSWORD);

?>
   

<html>
<link rel="stylesheet" type="text/css" href="mystyle.css">
<meta http-equiv="Content-type" content="text/html; charset=utf-8"/>
<div class="screen">
<head><h3>[Customer Search]</h3>
<nav>
            <a href="main.php">Home</a> |
            <a href="inventory.php">Inventory</a> |
            <a href="sales.php">Sales<a> |
            <a href="customerSearch.php">Customer Search<a> |
            <a href="EmployeeSearch.php">Employee Search<a> |
            <a href="checkout.php">Checkout</a>
</nav>
</head>

 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Live Data Search using Multiple Tag in PHP with Ajax</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput-typeahead.css" />
  <link rel="stylesheet" type="text/css" href="mystyle.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" />
  <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.js" crossorigin="anonymous"></script>

  <style>
  .bootstrap-tagsinput {
   width: 100%;
  }
  </style>
<div>
<input type="text" id="tags" class="form-control" data-role="tagsinput" />
</div>  
 </head>
      <tr>
       <th>CustomerID</th>
       <th>FirstName</th>
       <th>LastName</th>
       <th>Email</th>
       <th>Phone</th>
       <th>Address</th>
      </tr>


</html>

<script>
$(document).ready(function(){

 load_data();

 function load_data(query)
 {
  $.ajax({
   url:"FETCH.php",
   method:"POST",
   data:{query:query},
   dataType:"json",
   success:function(data)
   {
    $('#total_records').text(data.length);
    var html = '';
    if(data.length > 0)
    {
     for(var count = 0; count < data.length; count++)
     {
      html += '<tr>';
      html += '<td>'+data[count].Customer_ID+'</td>';
      html += '<td>'+data[count].First_Name+'</td>';
      html += '<td>'+data[count].Last_Name+'</td>';
      html += '<td>'+data[count].Email+'</td>';
      html += '<td>'+data[count].Phone+'</td>';
      html += '<td>'+data[count].Address+'</td></tr>';
     }
    }
    else
    {
     html = '<tr><td colspan="5">No Data Found</td></tr>';
    }
    $('tbody').html(html);
   }
  })
 }

 $('#search').click(function(){
  var query = $('#tags').val();
  load_data(query);
 });

});
</script>
