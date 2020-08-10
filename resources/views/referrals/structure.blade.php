@extends('layouts.admin')
@section('additionalCss')
<style>
.tree ul {
    padding-top: 20px; position: relative;
    
    transition: all 0.5s;
    -webkit-transition: all 0.5s;
    -moz-transition: all 0.5s;
}

.tree li {
    float: left; text-align: center;
    list-style-type: none;
    position: relative;
    padding: 20px 5px 0 5px;
    
    transition: all 0.5s;
    -webkit-transition: all 0.5s;
    -moz-transition: all 0.5s;
}

/*We will use ::before and ::after to draw the connectors*/

.tree li::before, .tree li::after{
    content: '';
    position: absolute; top: 0; right: 50%;
    border-top: 1px solid #ccc;
    width: 50%; height: 20px;
}
.tree li::after{
    right: auto; left: 50%;
    border-left: 1px solid #ccc;
}

/*We need to remove left-right connectors from elements without 
any siblings*/
.tree li:only-child::after, .tree li:only-child::before {
    display: none;
}

/*Remove space from the top of single children*/
.tree li:only-child{ padding-top: 0;}

/*Remove left connector from first child and 
right connector from last child*/
.tree li:first-child::before, .tree li:last-child::after{
    border: 0 none;
}
/*Adding back the vertical connector to the last nodes*/
.tree li:last-child::before{
    border-right: 1px solid #ccc;
    border-radius: 0 5px 0 0;
    -webkit-border-radius: 0 5px 0 0;
    -moz-border-radius: 0 5px 0 0;
}
.tree li:first-child::after{
    border-radius: 5px 0 0 0;
    -webkit-border-radius: 5px 0 0 0;
    -moz-border-radius: 5px 0 0 0;
}

/*Time to add downward connectors from parents*/
.tree ul ul::before{
    content: '';
    position: absolute; top: 0; left: 50%;
    border-left: 1px solid #ccc;
    width: 0; height: 20px;
}

.tree li a{
    border: 1px solid #ccc;
    padding: 5px 10px;
    text-decoration: none;
    color: #666;
    font-family: arial, verdana, tahoma;
    font-size: 11px;
    display: inline-block;
    
    border-radius: 5px;
    -webkit-border-radius: 5px;
    -moz-border-radius: 5px;
    
    transition: all 0.5s;
    -webkit-transition: all 0.5s;
    -moz-transition: all 0.5s;
}

/*Time for some hover effects*/
/*We will apply the hover effect the the lineage of the element also*/
.tree li a:hover, .tree li a:hover+ul li a {
    background: #c8e4f8; color: #000; border: 1px solid #94a0b4;
}
/*Connector styles on hover*/
.tree li a:hover+ul li::after, 
.tree li a:hover+ul li::before, 
.tree li a:hover+ul::before, 
.tree li a:hover+ul ul::before{
    border-color:  #94a0b4;
}
.member .metaInfo{
    display:none;
    border:solid 1px #000;
    background:#fff;
    position:absolute;
    bottom:100%;
    left:50%;
    padding:5px;
    width:auto;
    z-index: 9999;
}
.member:hover .metaInfo{
    display:block;   
}
.member .metaInfo img{
  width:35px;
  height:40px; 
  display:inline-block; 
  padding:5px;
  margin-right:5px;
    vertical-align:top;
  border:solid 1px #aaa;
}
.member .metaInfo p{
    word-wrap: break-word;
}
.person i{font-size: 20px;}
</style>
@stop
@section('content')
    <div class="row">
        <div class="structure_tree">
            @include('referrals.structureTree')
        </div>
    </div>
    <div class="row">
        <div class="card previous-level">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <a href="javascript:void(0);" class="btn btn-warning default btn-xl mb-2 previous">Back</a>
                        <a href="javascript:void(0);" class="btn btn-warning default btn-xl mb-2 reset-root">Reset</a>
                    </div>
                </div>                      
            </div>
        </div>
    </div>
@endsection
@section('userJs')
<script>
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

var userInfo = <?php echo json_encode($userInfo); ?>;
/*Store previous parentId*/
var prevParentId = userInfo.user_id;

/*when someone click on any member of tree then execute ajax request and recreate tree again*/
$(document).on("click",'.member_tree',function(){
    var parentId = $(this).data('rel');
    ajaxRequestCreateTree(parentId);
});

/*back button click*/
$(document).on("click",'.previous-level .previous',function(){
    //check if pqrent Id exist
    if(typeof (prevParentId) != "undefined" && prevParentId != ""){
        ajaxRequestCreateTree(prevParentId);
    }
});

/*Rest to Root*/
$(document).on("click",'.previous-level .reset-root',function(){
    //check if pqrent Id exist
    if(typeof (userInfo) != "undefined" && userInfo != ""){
        prevParentId = userInfo.user_id;
        ajaxRequestCreateTree(prevParentId);
    }
});

</script>
@stop