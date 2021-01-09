//how to json data print in php
<div id="amodel">     
	<div id="amodel-form" style="margin-top:32px;">
	    <h2>Year Attendance</h2>
	    <div id="allmonth"></div> <!-- yaha data show karna hai -->  
	</div>
</div>

<script>
$(document).on("click","#year",function(e){
        e.preventDefault();
        $("#amodel").show();
        var id=$(this).attr("data-user");
        var url= "<?php echo base_url()?>Admin/yearattendance";
        $.ajax({
            url : url,
            type: 'POST',
            data: {atten_emp:id},
            success:function(data)
            {
                //console.log(data);
                var parseData=JSON.parse(data);
                if(parseData.length>0){
                    var html="<table><tr><th>S.No</th><th>Month</th><th>Attendance</th></tr>";
                    var sr_no=0;
                    for(var i=0;i<parseData.length;i++){
                        sr_no++;
                        html+="<tr><td>"+sr_no+"</td><td>"+parseData[i].full_month+"</td><td>"+parseData[i].catten+"</td></tr>";
                    }
                    html+="</table>";
                    $("#allmonth").html(html);
                }
            }
        });
    });
</script>


	<?php
	//controller
    function yearattendance()
    {
        $atten_emp=$this->input->post("atten_emp");
        $date = date('Y-m-d');
        $month=date('m');
        $year=date('Y');
        $qry=$this->Vendor_model->yearattendance_model($atten_emp,$month,$year);
        echo json_encode($qry); //data json me convert kiya
    }
    ?>

    <?php
    //model
    function yearattendance_model($atten_emp,$month,$year)
    {
        $qry=$this->db->query("Select full_month,count(atten_emp) as catten from attendance where atten_emp='$atten_emp'  AND year='$year' AND attendance='Present' group by full_month order by aid='desc'");
        return $qry->result();
    }
    ?>
