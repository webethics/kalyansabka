@extends('layouts.admin')
@section('additionalCss')
<style>
#mainContainer{
    min-width:850px;
	margin-top: 50px;
}
.container{
    text-align:center;
    margin:10px .5%;
    padding:10px .5%;
    float:left;
    overflow:visible;
    position:relative;
}
.member{ 
    position:relative;
    z-index:   1;
    cursor:default;
}
.member:after{
    display:block;
    position:absolute;
    left:50%;
    width:1px; 
    height:20px;
    background:#000;
    content:" ";
    bottom:100%;
}
.member:hover{
 z-index:   2;
}
.member .metaInfo{
    display:none;
    border:solid 1px #000;
    background:#fff;
    position:absolute;
    bottom:100%;
    left:50%;
    padding:5px;
    width:100px;
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
.structure {
    width: 80px;
    margin: auto;
    border-radius: 80px;
    height: 80px;border:1px solid #000;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-pack: center;
        -ms-flex-pack: center;
            justify-content: center;
    -webkit-box-align: center;
        -ms-flex-align: center;
            align-items: center;
}
</style>
@stop
@section('content')
    <div id="mainContainer" class="clearfix"></div>
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
@endsection
@section('userJs')
<script>
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

var members = <?php echo json_encode($memberInfo);?>;
var userInfo = <?php echo json_encode($userInfo); ?>;
/*Store previous parentId*/
var prevParentId = userInfo.user_id;
var testImgSrc = "http://0.gravatar.com/avatar/06005cd2700c136d09e71838645d36ff?s=69&d=wavatar";
/*create tree structure with person info*/
function createTreeStructure(parentId){
    /* This is slow and iterates over each object everytime.
     Removing each item from the array before re-iterating 
     may be faster for large datasets. */
     /*Check if parentId is number then change type of it*/
     if($.isNumeric(parentId))
        parentId = parseInt(parentId);
    for(var i = 0; i < members.length; i++){
        var member = members[i];
        if(member.parentId === parentId){
            var parent = parentId ? $("#containerFor" + parentId) : $("#mainContainer"),
                memberId = member.memberId,
                personInfo = '<div class="person">'+
                            '<i class="iconsminds-user"></i>'+
                            '<p class="name">'+member.name+
                            '</p></div>';
                //metaInfo = "<img src='"+testImgSrc+"'/>" + member.email + " ($" + member.amount + ")";
                metaInfo = "<p class='info'>"+member.name+"</p><p class='info'>"+member.email+"</p><p class='info'> Total referral:"+member.counter+"</p>";
            parent.append("<div class='container' id='containerFor" + memberId + "'><a href='#' class='member_tree' data-rel="+memberId+"><div class='member'><div class='structure'>" + personInfo + "<div class='metaInfo'>" + metaInfo + "</div></div></div></a></div>");
            createTreeStructure(memberId);

            /*check if root tree is not same has login user then show back button*/
            if(parentId == null){
                if(memberId == userInfo.user_id){
                    $('.previous-level').addClass('d-none');
                }else{
                   $('.previous-level').removeClass('d-none'); 
                }
            }
        } 
    }
}


function manageWidth(){
    // makes it pretty:
    // recursivley resizes all children to fit within the parent.
    var pretty = function(){
        var self = $(this),
            children = self.children(".container"),
            // subtract 4% for margin/padding/borders.
            width = (100/children.length) - 2;
        children
            .css("width", width + "%")
            .each(pretty);
        
    };
    $("#mainContainer").each(pretty);
}

if(members.length > 0){
    callTreeStructureFn();
}


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

/*function that send ajax return and create member tree*/
function ajaxRequestCreateTree(parentId){
    /*Check if parent id not empty*/
    if(parentId != ""){
        /*Empty parent div*/
        $('#mainContainer').empty();

        /*show loader on content div*/
        $("body").addClass("show-spinner");
        let ajax_url = 'referral';
        //send ajax call
        $.ajax({
          type: "GET",
          url: ajax_url,
          data:{member_id:parentId},
          success: function (response) {
            $("body").removeClass("show-spinner");
            if(response.status == 'success'){
                if(typeof response.memberInfo != 'undefined' && response.memberInfo != null && response.memberInfo.length > 0){
                    /*fetch previous parent id*/
                    prevParentId = setPreviousParentId(members);
                    members = response.memberInfo;
                    callTreeStructureFn();
                }
            }else{
                if(typeof response.msg != 'undefined' && response.msg != ''){
                    alert(response.msg);
                }
                callTreeStructureFn();
            }
          },
          error:function(response){
            console.log('error');
            $("body").removeClass("show-spinner");
            callTreeStructureFn();
          }
        });

    }else{
        alert('Something went wrong');
    }

}

/*Function that call ans create tree structure and manage width*/
function callTreeStructureFn(){
    createTreeStructure(null);
    manageWidth();
}

/*functiob that returb parent id from members array*/
function setPreviousParentId(oldMembers){
    for(var i = 0; i < oldMembers.length; i++){
        var member = members[i];
        if(member.parentId === null){
            return member.memberId;
        }
    }
}

</script>
@stop