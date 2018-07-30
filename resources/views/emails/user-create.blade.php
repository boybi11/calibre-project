<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	
	<meta name="viewport" content="width=device-width"/>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<title>{{$options['name']}}</title>
	<link rel="stylesheet" type="text/css" href="stylesheets/email.css"/>
</head>
<body bgcolor="#FFFFFF">
	
	<table class="body-wrap">
		<tr>
			<td></td>
			<td class="container" bgcolor="#FFFFFF">
				<div class="content">
					<table>
						<tr>
							<td>
								<h3>Hi, {{$user['name']}},</h3>
								<p class="lead">Your password is {{$password}}</p>
								
								<table class="social" width="100%">
									<tr>
										<td>
											
											<table align="left" class="column">
												<tr>
													<td>
														<h5 class="">Connect with Us:</h5>
														<p class="">
															<a href="{{$options['facebook']}}" class="soc-btn fb">Facebook</a> 
															<a href="{{$options['twitter']}}" class="soc-btn tw">Twitter</a> 
															<a href="{{$options['google']}}" class="soc-btn gp">Google+</a></p>
													</td>
												</tr>
											</table> 
											
											<table align="left" class="column">
												<tr>
													<td>
														<h5 class="">Contact Info:</h5>
														<p>Phone: <strong>{{$options['number']}}</strong><br/>
															Email: <strong><a href="emailto:{{$options['email']}}">{{$options['email']}}</a></strong></p>
														</td>
													</tr>
												</table> 
												<span class="clear"></span>
											</td>
										</tr>
									</table> 
								</td>
							</tr>
						</table>
					</div> 
				</td>
				<td></td>
			</tr>
		</table> 
		
		<table class="footer-wrap">
			<tr>
				<td></td>
				<td class="container">
					
					<div class="content">
						<table>
							<tr>
								<td align="center">
									<p>
										<a href="{{$options['terms']}}">Terms</a> |
										<a href="{{$options['privacy']}}">Privacy</a> |
										<a href="{{$options['unsubscribe']}}"><unsubscribe>Unsubscribe</unsubscribe></a>
									</p>
								</td>
							</tr>
						</table>
					</div> 
				</td>
				<td></td>
			</tr>
		</table> 
	</body>
	</html>