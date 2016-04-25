<div> 
    <?php 
        $query = mysql_query("SELECT * FROM company_details");
        while($rows = mysql_fetch_assoc($query))
        { 
            $company_id = $rows['company_id']; 
        } 
    ?> 
    <img src="<? php echo $company_id ?>" height="150" width="120"/> 
  
</div>