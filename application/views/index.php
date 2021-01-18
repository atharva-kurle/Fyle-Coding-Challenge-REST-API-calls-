<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Fyle Coding Challenge</title>

  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" integrity="sha384-q2kxQ16AaE6UbzuKqyBE9/u/KzioAlnx2maXQHiDX9d4/zp8Ok3f+M7DPm+Ib6IU" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-pQQkAEnwaBkjpqZ8RU1fF1AKtTcHJwFl3pblpTlHXybJjHpMYo79HY3hIi4NKxyj" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

    <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

  <link rel="stylesheet" href="//cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
  <script src="//cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>



</head>
<body>

<h1 class="text-center">Fyle Coding Challenge</h1>
<h3 class="text-center">Instructions</h3>

<h6 class="text-center"><strong>1. You are able to use keywords for searching through all the fields. Eg. Seach : Pune or 110, etc. All the results related to pune or 110 will come.</strong><br>
<strong>2. By clicking on IFSC code, the page will redirect you to a new link with route as 'IFSC_code/bank_id'</strong><br>
<strong>3. You can search rows manually through query string. Eg.'http://localhost/api/branches?q=BANGALORE&limit=1&offset=1' will return all the rows with branch 'BANGALORE' in json format.</strong><br>
<strong>4. Pagination and page-length can be set using dropdown on the top-left of your screen. </strong><br>
<strong>5. The website is hosted on a paid server as I have owned for displaying personal projects. </strong><br>
<strong>6. You can filter all the fields from ascending to descending or vice-versa.</strong>
</h6>



<div class="row" style="margin-left: 10px;margin-right: 10px;">
<div class="col-md-12">
<table id="datatable">
<thead>
    <tr>
      <th>IFSC</th>
      <th>Bank ID</th>
      <th>Branch</th>
      <th>Address</th>
      <th>City</th>
      <th>District</th>
      <th>State</th>
      <th>type</th>
    </tr>
  </thead>
  <tbody>
    
  </tbody>
  <tfoot>
    <tr>
      <th>IFSC</th>
      <th>Bank ID</th>
      <th>Branch</th>
      <th>Address</th>
      <th>City</th>
      <th>District</th>
      <th>State</th>
      <th>type</th>
    </tr>
  </tfoot>
  
</table>
</div>

</div>
</body>


<script type="text/javascript">
$(document).ready(function(){
  $("#datatable").DataTable({
    'pageLength':5,
    'order':[],
    'serverSide':true,
     'ajax':{
      url: "<?php echo base_url();?>" + "fyle/show",
      type: "POST"
     },
    dom: "lBfrtip",
    "lengthMenu": [ [10,25,50], [10,25,50] ],
  });

});
</script>

</html>