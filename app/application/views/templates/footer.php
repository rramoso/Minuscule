       </div></div>
	<div  class="footer">
			<em> Minuscule &copy; Ricardo Ramos 2017</em> All rights reserved.
		</div>
        <!--load jQuery library-->
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
		<!--load bootstrap.js-->
		<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
		<script type="text/javascript">
		$(document).ready(function() {
			var origalH = $('.container').height();
			console.log(origalH);
			console.log($(document).height())
			$(document).bind('click',
                     function(e){
                         console.log($('.container').height());
                     });
			
		});


       </script>
		<style type="text/css">
		.footer{
			position: absolute;
			right: 0;
			bottom: 0;
			left: 0;
			padding: 1rem;
			background-color: #efefef;
			text-align: center;
		}
		#footer_bottom {
			background-color: #81ccff;
			padding-top: 13px;
			padding-bottom: 17px;
			margin-top:88px;
			position: 0;
			}
			#footer_bottom .copyright {
			text-align: center;
			font-size: 16px;
			color: #81ccff;
			}
			#footer_bottom .copyright a {
			color: #fff;
			font-size: 19px;
}		
		</style>

	</body>
</html>