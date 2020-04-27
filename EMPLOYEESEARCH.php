<?php                                                                                                                                                                   session_start();
                                                                                                                                                                        if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] == false){
        header("Location: login.php");
}
                                                                                                                                                                        ?>

<?php                                                                                                                                                                   require_once 'config.php';
require_once 'db.php';
                                                                                                                                                                        $db =connect(DB_HOST, DB_NAME, DB_USERNAME, DB_PASSWORD);
?>


<html>
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
 </head>
 <body>
  <div class="container">
   <br />
   <br />
   <br />
   <h2 align="center">EMPLOYEE SEARCH</h2><br />
   <div class="form-group">
    <div class="row">
     <div class="col-md-10">
      <input type="text" id="tags" class="form-control" data-role="tagsinput" />
     </div>
     <div class="col-md-2">
      <button type="button" name="search" class="btn btn-primary" id="search">Search</button>
     </div>
    </div>
   </div>
   <br />
   <div class="table-responsive">
    <div align="right">
     <p><b>Total Records - <span id="total_records"></span></b></p>
    </div>
    <table class="table table-bordered table-striped">
     <thead>
      <tr>
       <th>EmployeeID</th>
       <th>FirstName</th>
       <th>LastName</th>
       <th>BankAccountNum</th>
       <th>RoutingNum</th>
       <th>Address</th>
       <th>PhoneNumber</th>
      </tr>
     </thead>
     <tbody>
     </tbody>
    </table>
   </div>
  </div>
  <div style="clear:both"></div>
  <br />
  
  <br />
  <br />
  <br />
 </body>
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
      html += '<td>'+data[count].EmployeeID+'</td>';
      html += '<td>'+data[count].FirstName+'</td>';
      html += '<td>'+data[count].LastName+'</td>';
      html += '<td>'+data[count].BankAccountNum+'</td>';
      html += '<td>'+data[count].RoutingNum+'</td>';
      html += '<td>'+data[count].Address+'</td>';
      html += '<td>'+data[count].PhoneNumber+'</td></tr>';
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
