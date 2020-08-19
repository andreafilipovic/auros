var selectedCatId=1;
var serverUrl="http://localhost/php2g2t1/";
var baseUrl="http://localhost/php2g2t1/index.php";
var adresa=window.location.href;

window.onload=function(){
showNav();

if(adresa==baseUrl || adresa==baseUrl+"?page=home" || adresa==baseUrl+"?page=home#products"){
  var elem = document.querySelector('.grid-slider-wrapper');
  var flkty = new Flickity( elem, {
    cellAlign: 'left',
    //contain: true,
    autoPlay: 2500,
    wrapAround:true,
    groupCells: 1
  });
}

$("#ddlSort").change(sortProduct);
 
$("#btnInsertNew").click(function(e){
  e.preventDefault();
  checkInsert();
});
$("#btnContact").click(function(e){
  e.preventDefault();
  kontakt();
})
$("#btnAddNewOrder").click(function(e){
  e.preventDefault();
  checkNewOrder();
});

$("#btnUpdate").click(function(e){
  e.preventDefault();
  proveriPodatke();
});

$(".deleteProduct").click(deleteProduct);
$(".btnDeleteOrder").click(deleteOrder);
var btnInsert=document.getElementById("addNewProductBtn");
var modalInsert = document.getElementById("modalInsert");
var spanInsert = document.getElementsByClassName("closeInsert")[0];
var btnUpdate=document.getElementsByClassName("editProduct");
var modalUpdate = document.getElementById("updateForm");
var spanUpdate = document.getElementsByClassName("closeUpdate")[0];
if(adresa.indexOf("admin")!==-1){
  spanInsert.onclick = function() {
  modalInsert.style.display = "none";
  }
  spanUpdate.onclick = function() {
    modalUpdate.style.display = "none";
    }
}
if(adresa.indexOf("admin")!==-1){
  btnInsert.onclick = function() {
    modalInsert.style.display = "block";
  }
 }
 

window.onclick = function(event) {
  if (event.target == modalInsert) {
    modalInsert.style.display = "none";
  }
  if (event.target == modalUpdate) {
    modalUpdate.style.display = "none";
  }
}


$("body").on("click", ".editProduct", function(){

  var obj=$(this).data('obj');
  //console.log(obj);
  fillData(obj);
$("#updateForm").fadeIn("300");
});


$("body").on("click", ".emp-pagination", function(){

  let limit = $(this).data("limit");

  $.ajax({
      url:"index.php?page=getProductWithPag",
      method: "GET",
      dataType:"json",
      data: {
          limit: limit
      },
      success: function(data){
          //console.log(data.allProd);
          printProductSomeProducts(data.allProd);
          printPag(data.pagNum);
          
      },
      error: function(error){
          console.log(error);
      }
  })
  
});

function checkNavPosition() {
  if($(window).scrollTop() <= 50) {
      $('.nav').removeClass('active');
  } else {
      $('.nav').addClass('active');
  }
}

checkNavPosition();

$(document).scroll(function() { 
  checkNavPosition()
});

$(".btnAddToCart").click(addToCard);
$(".btnRemoveCard").click(removeFromCard);
$("#meniCat a").click(function(e){
  e.preventDefault();
  let id=$(this).data('id');
  dohvatiProizvode(id);
});


function addToCard(){
  let id=$(this).data('id');
  $.ajax({
    url:"index.php?page=card",
    type:'POST',
    data:{id:id},
    success:function(data,status,xhr){
      
        alert("Added successfully!");
      
    },
    error:function(xhr,status,error){
      switch(xhr.status){
          case 500: alert("Greska na serveru");
          break;
          case 404: alert("stranica nije pronadjena");
          break;
          case 409:  alert("You must be logged in to add a product!");
          break;
          case 403:  alert("You must be logged in to add a product!");
          break;
          default: alert("Greska"+status+"-"+statusT);
          break;
      }
    }
  });
}



function dohvatiProizvode(catId){
  selectedCatId=catId
   $.ajax({
    url: 'index.php?page=kategorija',
    type: 'POST',
    data:{catId:catId},    
    dataType: 'json',
    success: function (data) {
        //console.log(data);
        //console.log(selectedCatId);
        printProductSomeProducts(data);
        
    },
    error: function (xhr,status,error) {
        alert(xhr.status + status);
    }
  });
}


var modal = document.getElementById("myModalLogin");
var btn = document.getElementById("btnModal");
var span = document.getElementsByClassName("close")[0];

btn.onclick = function() {
  modal.style.display = "block";
}
span.onclick = function() {
  modal.style.display = "none";
}
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}

$("#signup-link").click(showRegisterForm);

$("#login-link").click(showLoginForm);

//console.log(selectedCatId);

};

function removeFromCard(){
  let id=$(this).data('id');
  //alert(id);
  $.ajax({
    url:"index.php?page=bag&id="+id,
    type:'post',
    data:{id:id},
    dataType:'json',
    success:function(data){
      getProductFromCard();
    },
    error:function(xhr,status,error){
      alert(xhr.status + status);
    }
  });
}

function getProductFromCard(){
  $.ajax({
    url:"index.php?page=getCard",
    type:'post',
    dataType:'json',
    success:function(data){
      if(data.length){
      printProductCart(data);
      }else{
        showEmptyCart();
      }
    },
    error:function(xhr,status,error){
      alert(xhr.status + status);
    }
  });
}

function sortProduct(){
  var sort=document.getElementById('ddlSort');
  var selectedSort=sort.options[sort.selectedIndex].value;

  $.ajax({
    url: 'index.php?page=sort',
    type: 'POST',
    data:{sortBy:selectedSort,catId:selectedCatId,btnSort:true},    
    dataType: 'json',
    success: function (data) {
        printProductSomeProducts(data);
        
    },
    error:function(xhr,status,error){
      alert(xhr.status + status);
    }
  });

}

function showNav(){
  $.ajax({
    url:'index.php?page=nav',
    type: 'GET',
    dataType: 'json',
    success: function (data) {
      console.log(data);
        printNav(data);
        
    },
    error:function(xhr,status,error){
      alert(xhr.status + status);
    }
  });
}

function printNav(data){
  var show="";
  for(let d of data){
    show+=`
    <li><a href="${d.link}">${d.title}</a></li>
    `
  };
  document.getElementById("mainMeni").innerHTML=show;
}


function checkLogin(){
  var mail=document.getElementById("emailLogin").value;
    var pass=document.getElementById("passwordLogin").value;

    var reMail=/^[a-z]{2,}[\.\$\%\!\?\.\#\^\\\/]*[A-z0-9]*[\.\$\%\!\?\.\#\^\\\/]*[A-z0-9]*[@][a-z]{2,}\.[a-z]{2,}$/;
    var rePas=/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/;

    var flag=true;
    document.getElementById("error-emailLogin").innerHTML="";
    document.getElementById("error-passwordLogin").innerHTML="";
    if (!reMail.test(mail)) {
		
        document.getElementById("error-emailLogin").innerHTML+="Incorrect e-mail";	
        flag=false;
	}
	else{
		
        document.getElementById("error-emailLogin").innerHTML="";  
    }
    if (!rePas.test(pass)) {
		
        document.getElementById("error-passwordLogin").innerHTML+=" Incorrect password";	
        flag=false;
	}
	else{
		
        document.getElementById("error-passwordLogin").innerHTML="";  
    }
    //console.log(flag);
return flag;

}

function checkRegister(){
  var fullName=$("#fullName").val();
        //console.log(fullName);
        var email=$("#emailReg").val();
        var password=$("#passwordReg").val();
   
        var reName=/^[A-Z][a-z]{2,}(\s[A-Z][a-z]{2,})+$/;
        var reEmail=/^[a-z]{2,}[\.\$\%\!\?\.\#\^\\\/]*[A-z0-9]*[\.\$\%\!\?\.\#\^\\\/]*[A-z0-9]*[@][a-z]{2,}\.[a-z]{2,}$/;
        var rePassword=/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/;
   
    
        var flag=true;
        if(!reName.test(fullName)){
           $("#errorReg-name").html("incorrect format for name");
          flag=false;
        }
        else{
           $("#errorReg-name").html("");
           
        }
   
        if(!reEmail.test(email)){
           $("#errorReg-mail").html("incorrect format");
 
          flag=false;
        }
        else{
           $("#errorReg-mail").html("");
           
        }
   
        if(!rePassword.test(password)){
           $("#errorReg-pass").html("incorrect format");
           flag=false;
        }
        else{
           $("#errorReg-pass").html("");
           
        }

        return flag;
}


function proveriPodatkee(){
     var name=document.getElementById('productName').value;
     var price=document.getElementById('producPrice').value;
     var catList=document.getElementById("productCat");
     var img=document.getElementById("productPic").value;
     var des=document.getElementById("productDescription").value;

     //console.log(img);
    
    
     var selectedCat=catList.options[catList.selectedIndex].value;
     //console.log(selectedCat);
     
     var reName=/^[A-Z][a-z]{2,}(\s[A-Z][a-z]{1,})*$/;
     var rePrice=/^[1-9][0-9]*$/;
     var rePic=/^[^\s]+\.(jpg|png|gif|jpeg)$/;
 
     var flag =true;
     
     if(!rePic.test(img)){
         document.getElementById("error-pic-insert").innerHTML="You must uploda a photo";
         flag=false;
     }
     if (!reName.test(name) || name.length==0) {
         
         document.getElementById("error-name-insert").innerHTML="please retry with a correct format";	
         flag=false;
     }
     else{
         
         document.getElementById("error-name-insert").innerHTML="";
         
     }
 
     if (!rePrice.test(price) || price.length==0) {
         
         document.getElementById("error-price-insert").innerHTML="price can't be zero or less";
         flag=false;
     }
     else{
         
         document.getElementById("error-price-insert").innerHTML="";
        
     }
     
 
     if (selectedCat=="0") {
         document.getElementById("error-cat-insert").innerHTML="please select categoty";
         flag=false;
     }
     else{
         document.getElementById("error-cat-insert").innerHTML=""
         
     }
 
     //console.log(flag);
     return flag;
}
function checkNewOrder(){
  var name=document.getElementById("ddlUser");
  var selectedName=name.options[name.selectedIndex].value;
  var product=document.getElementById("ddlProduct");
  var selectedProd=product.options[product.selectedIndex].value;
  var flag=true;
  if (selectedName=="Select") {
    document.getElementById("error-name").innerHTML="please select one user";
    flag=false;
  }
  else{
    document.getElementById("error-name").innerHTML=""
    
  }
  if (selectedProd=="Select") {
    document.getElementById("error-prod").innerHTML="please select one product";
    flag=false;
  }
  else{
    document.getElementById("error-prod").innerHTML=""
    
  }

  if(flag){
    $.ajax({
      url: 'index.php?page=addOrder',
      method: "POST",
      data: {
        ddlUser:selectedName,
        ddlProduct:selectedProd,
        btnAddNewOrder:true
      },
      success: function(data) {
        getAllOrders();
      },
      error:function(xhr,status,error){
        alert(xhr.status + status);
      }
    });
  }
  
}

function proveriPodatke(){
  var name=document.getElementById('nameUpdate').value;
    var price=document.getElementById('priceUpdate').value;
    var des=document.getElementById('desUpdate').value;
    var catList=document.getElementById("ddlCatUpdate");
    var img=document.getElementById("picUpdate").value;
    var selectedCat=catList.options[catList.selectedIndex].value;
    var idP=document.getElementById("idProductUpdate").value;
    var pic=document.getElementById("picUpdate");
    var fajl=pic.files[0];
    //console.log(img);

    var formData = new FormData();
    formData.append("pic", fajl);
    formData.append("des", des);
    formData.append("ddlCat", selectedCat);
    formData.append("name", name);
    formData.append("price", price);
    formData.append("idProduct", idP);
    formData.append("btnUpdate", true);
    
    var reName=/^[A-Z][a-z]{2,}(\s[A-Z][a-z]{1,})*$/;
    var rePrice=/^[1-9][0-9]*$/;
    var rePic=/^[^\s]+\.(jpg|png|gif|jpeg)$/;

    var flag =true;
    if(img.length==0){
        flag=true;
    }

    if(!rePic.test(img) && img.length>0){
        document.getElementById("error-pic-update").innerHTML="You can uploda just a photo";
        flag=false;
    }
    if (!reName.test(name) || name.length==0) {
		
        document.getElementById("error-name-update").innerHTML="please retry with a correct format";	
        flag=false;
	}
	else{
		
        document.getElementById("error-name-update").innerHTML="";
        
    }

    if (!rePrice.test(price) || price.length==0) {
		
        document.getElementById("error-price-update").innerHTML="price can't be zero or less";
        flag=false;
	}
	else{
		
        document.getElementById("error-price-update").innerHTML="";
       
    }
    

	if (selectedCat=="Select") {
        document.getElementById("error-cat-update").innerHTML="please select categoty";
        flag=false;
	}
	else{
        document.getElementById("error-cat-update").innerHTML=""
        
    }
    if(flag){
      
      $.ajax({
        url: 'index.php?page=update',
        method: "POST",
        data: formData,
        contentType: false,
        cache: false, 
        processData: false,
        success: function(data) {
          getAllProductAdmin();
          document.getElementById("updateForm").style.display = "none";
        },
        error:function(xhr,status,error){
          alert(xhr.status + status);
        }
      });
    }
  
}

function checkInsert(){
  // e.stopPropagation();
  
  var name=document.getElementById('name').value;
    var price=document.getElementById('price').value;
    var catList=document.getElementById("ddlCat");
    var pic=document.getElementById("pic").value;
    var img=document.getElementById("pic");
    var fajl=img.files[0];
    var des=document.getElementById("productDes").value;
    var selectedCat=catList.options[catList.selectedIndex].value;
   //console.log(pic);
    var formData = new FormData();
    formData.append("pic", fajl);
    formData.append("des", des);
    formData.append("ddlCat", selectedCat);
    formData.append("name", name);
    formData.append("price", price);
    formData.append("btnInsertNew", true);
    //var form = $('form')[2];
    //console.log(form);
 
  
  var greske=[];
   //console.log("blabla");
   
    var selectedCat=catList.options[catList.selectedIndex].value;
    //console.log(selectedCat);
    
    var reName=/^[A-Z][a-z]{2,}(\s[A-Z][a-z]{1,})*$/;
    var rePrice=/^[1-9][0-9]*$/;
    var rePic=/^[^\s]+\.(jpg|png|gif|jpeg)$/;
   
    var flag =true;
  

    if(!rePic.test(pic)){
        document.getElementById("error-pic").innerHTML="You can uploda photo";
        greske.push("You can uploda photo");
        flag=false;
    }else{
      document.getElementById("error-pic").innerHTML="";
    }
    if (!reName.test(name) || name.length==0) {
		
        document.getElementById("error-name").innerHTML="please retry with a correct format";	
        flag=false;
        greske.push("please retry with a correct format");
        
	}
	else{
		
        document.getElementById("error-name").innerHTML="";
        
    }

    if (!rePrice.test(price) || price.length==0) {
		
        document.getElementById("error-price").innerHTML="price can't be zero or less";
        flag=false;
        greske.push("price can't be zero or less");
        
	}
	else{
		
        document.getElementById("error-price").innerHTML="";
       
    }
    

	if (selectedCat=="Select") {
        document.getElementById("error-cat").innerHTML="please select categoty";
        flag=false;
        greske.push("please select categoty");
        
	}
	else{
        document.getElementById("error-cat").innerHTML=""
        
    }
     
  //   console.log(flag);
    if(flag){
      
      $.ajax({
        url: 'index.php?page=insert',
        method: "POST",
        data: formData,
        contentType: false,
        cache: false, 
        processData: false,
        success: function(data) {
          getAllProductAdmin();
          modalInsert.style.display = "none";
        },
        error:function(xhr,status,error){
          alert(xhr.status + status);
        }
      });
    }
    
  
}


function printPag(data){
  let printPag="";
  for(let i = 0; i <data; i++){
      printPag += `
              
              <li class="emp-pagination" data-limit="${i}"> ${ i + 1 }</li>
  `;
  }

  document.getElementById("listPag").innerHTML=printPag;
}

function printProductSomeProducts(data){
  var show="";
  for(let d of data){
    show+=`
 <div class="col-md-12 col-sm-12 oneProduct polaroid">
    <img src="assets/images/${d.picture}" class="imgProduct col-lg-12">
    <div class="namePrice col-lg-12">
        <p>${d.nameProduct}</p>
        <p class="price">$ ${d.price}.00</p>
    </div>
    <div class="details col-lg-12">
        <a href="index.php?page=product&id=${d.idProduct}" class="btnView">View</a>
    </div>  
</div>`
  };
  document.getElementById("products").innerHTML=show;

}


function showRegisterForm(){
  $("#loginForm").hide();
  $("#formReg").show();
}

function showLoginForm(){
  $("#formReg").hide();
  $("#loginForm").show();
}


function getProductDetails(id){
  $.ajax({
    url: 'index.php?page=product',
    type: 'POST',
    data:{id:id},
    dataType: 'json',
    success: function (data) {
        //alert("success");
        console.log(data);
        //printProductDetails(data);
        
    },
    error:function(xhr,status,error){
      alert(xhr.status + status);
    }
  });
}


function printProductDetails(data){
 
  let prikaz=`<div id="myModalProduct" class="modalProduct">

  <!-- Modal content -->
  <div class="modal-contentProduct">
    <span class="closeProduct">&times;</span>
    <div class="col-lg-12" id="productDetails">`
    for(let d of data){
      prikaz+=`<div class="col-lg-6 col-sm-12 picture">
      <img src="assets/images/${d.picture}>" alt="" class="col-lg-12">
  </div>
  <div class="col-lg-6 col-sm-12 detail-text">
      <h2>${d.nameProduct}</h2>
      <p class="detail-price">$${d.price}.99</p>
      <p class="detail-description">${d.description}</p>
      <button data-id="${d.idProduct}" class="btnAddToCart"><i class="fa fa-shopping-cart fa-lg" aria-hidden="true"></i>Add To Cart</button>
      <p class="categories"><i class="categoriesName">Categories:</i> All, ${d.nameCat}</p>
  </div>`
    }
    prikaz+=`       </div>
    </div>
  
  </div>`
}

function showEmptyCart() {
    
  document.getElementById("allProductsCard").innerHTML="<h1>Your cart is currenlty empty!</h1>";
}


function printProductCart(data){
  var show="";
  for(let d of data){
    show+=`
 <div class="col-lg-4 col-md-4 col-sm-12 oneProduct">
    <img src="assets/images/${d.picture}" class="imgProduct col-lg-12">
    <div>
        <p>${d.nameProduct}</p>
        <p class="price">$ ${d.price}.00</p>
        <button class="btnRemoveCard" data-id="${d.idCart}">Remove</button>
    </div>  
</div>`
  };
  document.getElementById("allProductsCard").innerHTML=show;
  $(".btnRemoveCard").click(removeFromCard);
}

function deleteProduct(){
  var id=$(this).data('id');
  //alert(id);
  $.ajax({
      method:"POST",
      url:"index.php?page=delete",
      dataType:"json",
      data:{
          id:id
      },
      success:function(data,status,xhr){
         getAllProductAdmin();
      },
      error(xhr,statusT,error){
          var status=xhr.status;
          switch(status){
              case 500: alert("Greska na serveru");
              break;
              case 404: alert("stranica nije pronadjena");
              break;
              default: alert("Greska"+status+"-"+statusT);
              break;
          }
      }
  })
}

function deleteOrder(){
  let id=$(this).data('id');
  //alert(id);
  $.ajax({
    url:"index.php?page=deleteOrder",
    method:"post",
    dataType:"json",
    data:{id:id},
    success:function(data){
        getAllOrders();
    },error:function(xhr,status,error){
      console.log(xhr.status);
    }

  });
}

function getAllOrders(){
  $.ajax({
    url:"index.php?page=getAllOrders",
    method:"get",
    dataType:"json",
    success:function(data){
        printAllOrders(data);
    },error:function(xhr,status,error){
      console.log(xhr.status);
    }

  });
}

function printAllOrders(data){
  var show="";
  for(let order of data){
    show+=`
    <td class="col-lg-3 col-sm-12">${order.fullName}</td>
    <td class="col-lg-3 col-sm-12">${order.nameProduct}</td>
    <td class="col-lg-3 col-sm-12">${formatDate(order.date)}</td>
    <td class="col-lg-3 col-sm-12"><button class="btnDeleteOrder" data-id="${order.idCart}">Delete</button></td>
    `
  };
  document.getElementById("oneOrder").innerHTML=show;
  $(".btnDeleteOrder").click(deleteOrder);
}

function formatDate($data){
  var datum=new Date($data);
  var god=datum.getFullYear();
  var mesec=datum.getMonth()+1;
  var dan=datum.getDate();
  var d= dan+"."+mesec+"."+god;
  return d;
}

function  printProductAdmin(data){
  var show="";
  for(let p of data){
    show+=`
    <div class="col-lg-12 oneProdAdmin">
    <div class="col-lg-2 col-sm-12 admin">
        <img class="col-lg-12" src="assets/images/${p.picture}" alt="${p.nameProduct}">
    </div>
    <div class="col-lg-2 col-sm-12 admin descAdmin">${p.description}</div>
    <div class="col-lg-2 col-sm-12 admin">${p.nameProduct}</div>
    <div class="col-lg-2 col-sm-12 admin">${p.nameCat}</div>
    <div class="col-lg-2 col-sm-12 admin">$${p.price}.00</div>
    <div class="col-lg-2 col-sm-12 admin">
        <button class="deleteProduct btn" data-id="${p.idProduct}">Delete</button>
        <button class="editProduct btn" data-obj='${JSON.stringify(p)}'>Edit</button>
    </div>
</div>`
  };
  document.getElementById("allProductsAdmin").innerHTML=show;
  $(".deleteProduct").click(deleteProduct);
  
}

function getAllProductAdmin(){
  $.ajax({
    url:"index.php?page=getAll",
    method:"get",
    dataType:"json",
    success:function(data){
      //console.log(data);
      printProductAdmin(data);
    },error:function(d){
      console.log(d);
    }

  })
}


function fillData(obj){
  document.getElementById('nameUpdate').value=obj.nameProduct;
  document.getElementById('priceUpdate').value=obj.price;
  document.getElementById('desUpdate').value=obj.description;
  var cat=document.getElementById('ddlCatUpdate');
  var selectedCategory=cat.options[cat.selectedIndex].value=obj.idCat;
  var selectedCategoryName=cat.options[cat.selectedIndex].text=obj.nameCat;
  document.getElementById('idProductUpdate').value=obj.idProduct;
}

function kontakt(){
  var ime=document.getElementById('fname').value;
  var mail=document.getElementById('Email').value;
  
  var mes=document.getElementById('mes').value;
  var reMail=/^[a-z]{2,}[\.\$\%\!\?\.\#\^\\\/]*[A-z0-9]*[\.\$\%\!\?\.\#\^\\\/]*[A-z0-9]*[@][a-z]{2,}\.[a-z]{2,}$/;
  
  var flag=true;
  var reIme=/^[A-Z][a-z]{2,}(\s[A-Z][a-z]{1,})+$/;
  if(!reIme.test(ime)){
      document.getElementById("error-fname").innerHTML="Incorrrect form";
      flag=false;
  }
  else{
      document.getElementById("error-fname").innerHTML=""
  }
  if(!reMail.test(mail)){
      document.getElementById("error-Email").innerHTML="Incorrrect form";
      flag=false;
  }
  else{
      document.getElementById("error-Email").innerHTML=""
  }
 
  if(mes.length<=0){
      document.getElementById("error-mess").innerHTML="Textbox can't be empty";
      flag=false;
  }
  else{
      document.getElementById("error-mess").innerHTML=""
  }
  
  //console.log(flag);
  if(flag){
    data={send:true,mail:mail,tekst:mes}
    $.ajax({
      url:"index.php?page=message",
      dataType:"json",
      data:data,
      method:"post",
      success:function (xhr,status,error) {
      
        alert("Email sent successfully")
      },
     error:function (xhr,status,error) {
      alert(xhr.status)
      }
      });
     
  }
  

}
