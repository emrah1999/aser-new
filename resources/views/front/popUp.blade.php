<style>
          div#popUpForm {
    position: absolute;
    width: 100%;
    background-color: #00000082;
  	z-index: 5;
	display: none;
  	height: 100%;
}

#popContainer {
    width: 365px;
    text-align: center;
    margin: 0 auto;
    background-color: #bdbdbd;
    height: 400px;
    margin-top: 80px;
	z-index: 5;
}
#close{
  border:solid 1px;
  width:23px;
  padding:3px;
  background-color:#f25822; 
  float:right;  
  margin:10px;
  cursor:pointer;
  border-radius:2px;
  font-weight:bold;
}
#close:hover{
  background-color:#ff44449e;
}

#popcontain{
  width:100%;
  height:100%;
  position:absolute;
  }
</style>

<div id="popcontain">
  <div id="popUpForm">
    <div id="popContainer">
    	<div id="close">X</div><br>
		<div style="padding: 8rem 2rem">
			<h4>Almaniya anbarımız yeni ünvanda!</h4>
			<h5>
				Yeni anbar ünvanını şəxsi hesabınızdan əldə edə bilərsiniz.
				<br/>
				<strong>
					15.10.2023-cü il tarixinə qədər köhnə anbara çatdırılan bağlamalar qəbul ediləcək.
				</strong>
			</h5>
		</div>
    </div>
  </div>
</div>
<script src="{{asset("frontend/js/jquery-3.4.1.js")}}"></script>
<script>
    $(document).ready(function() { 
		$('#popUpForm').fadeIn(1000);   
	});
	$( "#close" ).click(function() {
		$( "#popUpForm" ).css("display", "none");
	});
</script>