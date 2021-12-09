<?php 
if(isset($_GET['id'])){
    $qry = $conn->query("SELECT *, concat(lastname,', ',firstname,' ', middlename) as fullname FROM clients where id = '{$_GET['id']}' ");
    if($qry->num_rows > 0){
        foreach($qry->fetch_array() as $k=>$v){
            $$k= $v;
        }
    }
    
}
?>
<div class="card card-outline card-primary">
    <div class="card-header">
        <h5 class="card-title">Client Details</h5>
    </div>
    <div class="card-body">
        <div class="container-fluid" id="print_out">
            <style>
                img#cimg{
                    height: 20vh;
                    width: 20vh;
                    object-fit: scale-down;
                    object-position: center center;
                }
            </style>
                <div class="row">
                    <div class="col-md-4">
                        <img src="<?php echo validate_image(isset($id) ? "uploads/client-".$id.".png" :'')."?v=".(isset($date_updated) ? strtotime($date_updated) : "") ?>" alt="client Image" class="img-fluid bg-dark-gradient" id="cimg">
                    </div>
                </div>
            <div class="row">
                <div class="col-md-6">
                    <dl>
                        <dt class="text-info">Name:</dt>
                        <dd class="fw-bold pl-3"><?php echo isset($fullname) ? $fullname : "" ?></dd>
                        <dt class="text-info">Gender:</dt>
                        <dd class="fw-bold pl-3"><?php echo isset($gender) ? $gender : "" ?></dd>
                        <dt class="text-info">Contact #:</dt>
                        <dd class="fw-bold pl-3"><?php echo isset($contact) ? $contact : "" ?></dd>
                    </dl>
                </div>
                <div class="col-md-6">
                    <dl>
                        <dt class="text-info">Email:</dt>
                        <dd class="fw-bold pl-3"><?php echo isset($email) ? $email : "" ?></dd>
                        <dt class="text-info">Address:</dt>
                        <dd class="fw-bold pl-3"><?php echo isset($address) ? $address : "" ?></dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer text-center">
            <button class="btn btn-flat btn-sn btn-success" type="button" id="print"><i class="fa fa-print"></i> Print</button>
            <a class="btn btn-flat btn-sn btn-primary" href="<?php echo base_url."admin?page=client/manage_client&id=".$id ?>"><i class="fa fa-edit"></i> Edit</a>
            <a class="btn btn-flat btn-sn btn-dark" href="<?php echo base_url."admin?page=client" ?>">Back to List</a>
    </div>
</div>
<script>
    $(function(){
        $('#print').click(function(){
            start_loader()
            var _el = $('<div>')
            var _head = $('head').clone()
                _head.find('title').text("Client Details - Print View")
                _head.append($('#libraries').clone())
            var p = $('#print_out').clone()
            p.find('tr.text-light').removeClass("text-light bg-navy")
            _el.append(_head)
            _el.append('<div class="d-flex justify-content-center">'+
                      '<div class="col-1 text-right">'+
                      '<img src="<?php echo validate_image($_settings->info('logo')) ?>" width="65px" height="65px" />'+
                      '</div>'+
                      '<div class="col-10">'+
                      '<h4 class="text-center"><?php echo $_settings->info('name') ?></h4>'+
                      '<h4 class="text-center">Client Details</h4>'+
                      '</div>'+
                      '<div class="col-1 text-right">'+
                      '</div>'+
                      '</div><hr/>')
            _el.append(p.html())
            var nw = window.open("","","width=1200,height=900,left=250,location=no,titlebar=yes")
                     nw.document.write(_el.html())
                     nw.document.close()
                     setTimeout(() => {
                         nw.print()
                         setTimeout(() => {
                            nw.close()
                            end_loader()
                         }, 200);
                     }, 500);
        })
    })
</script>