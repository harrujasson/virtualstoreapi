<!DOCTYPE html">
<html xmlns="http://www.w3.org/1999/xhtml"
      style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
<head>
    <meta name="viewport" content="width=device-width"/>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>Billing</title>


    <style type="text/css">
        img {
            max-width: 100%;
        }

        body {
            -webkit-font-smoothing: antialiased;
            -webkit-text-size-adjust: none;
            width: 100% !important;
            height: 100%;
            line-height: 1.6em;
        }

        body {
            background-color: #f6f6f6;
			color: #666f7b;
        }

        @media only screen and (max-width: 640px) {
            body {
                padding: 0 !important;
            }

            h1 {color: #666f7b;
                font-weight: 800 !important;
                margin: 20px 0 5px !important;
            }

            h2 {color: #666f7b;
                font-weight: 800 !important;
                margin: 20px 0 5px !important;
            }

            h3 {color: #666f7b;
                font-weight: 800 !important;
                margin: 20px 0 5px !important;
            }

            h4 {color: #666f7b;
                font-weight: 800 !important;
                margin: 20px 0 5px !important;
            }

            h1 {color: #666f7b;
                font-size: 22px !important;
            }

            h2 {color: #666f7b;
                font-size: 18px !important;
            }

            h3 {color: #666f7b;
                font-size: 16px !important;
            }

            .container {
                padding: 0 !important;
                width: 100% !important;
            }

            .content {
                padding: 0 !important;
            }

            .content-wrap {
                padding: 10px !important;
            }

            .invoice {
                width: 100% !important;
            }
        }
    </style>
</head>
<?php $product = json_decode($r->product_information);?>



<body itemscope itemtype="http://schema.org/EmailMessage"
      style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; -webkit-font-smoothing: antialiased; -webkit-text-size-adjust: none; width: 100% !important; height: 100%; line-height: 1.6em; background-color: #f6f6f6; margin: 0;"
      bgcolor="#f6f6f6">

<table class="body-wrap"
       style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; background-color: #f6f6f6; margin: 0;"
       bgcolor="#f6f6f6">
    <tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
        <td style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;"
            valign="top"></td>
        <td class="container" width="600"
            style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;"
            valign="top">
            <div class="content"
                 style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; max-width: 600px; display: block; margin: 0 auto; padding: 20px;">
                <table class="main" width="100%" cellpadding="0" cellspacing="0"
                       style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; border-radius: 3px;  margin: 0; border: none;"
                       >
                    <tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                        <td class="content-wrap aligncenter"
                            style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;padding: 20px;border: 0px solid #46a5b6;border-radius: 7px; background-color: #fff;"
                            align="center" valign="top">
                            <table width="100%" cellpadding="0" cellspacing="0"
                                   style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                
                                <tr>
                                    <td style="vertical-align: top; padding-top:30px;" align="left">

                                    <a href="javascript:void(0)" target="_blank">
                                        @if($inv_logo!="")
                                        <img src="{{asset('uploads/profile/'.$inv_logo)}}" width="200" height="50" style="width:200px;"><br/>
                                        @endif
                                    </a> 
                                    <BR>
                                    {{$inv_address}} <br>
                                    {{$inv_phone}} <br>
                                    {{$inv_email}}
                                </td>

                                    <td style="vertical-align: top; padding-top:30px; font-size: 26px; color: #666f7b; font-weight: 600;" align="right">Invoice</td>
                                </tr>
                                
                                @if($r->cancel == 1)
                                <tr>
                                    <td colspan="2" style="vertical-align: top; padding-top:30px; font-size: 26px; color: #666f7b; font-weight: 600;" align="center"><img src="{{asset('assets/images/cancel_invoice.jpeg')}}" width="100"  style="width:100px;"></td>
                                </tr>
                                @endif
                                <tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                    <td class="content-block"
                                        style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;"
                                        valign="top">
                                        <h3 class="aligncenter"
                                            style="font-family: 'Helvetica Neue',Helvetica,Arial,'Lucida Grande',sans-serif; box-sizing: border-box; font-size: 16px; color: #666f7b; line-height: 1.2em; font-weight: 400; text-align: left; margin: 40px 0 0; font-weight: 600;"
                                            align="left">Dear {{$r->shipping->ship_name}}</h3>
	                                    <h3 class="aligncenter"
                                            style="font-family: 'Helvetica Neue',Helvetica,Arial,'Lucida Grande',sans-serif; box-sizing: border-box; font-size: 14px; color: #666f7b; line-height: 1.2em; font-weight: 400; text-align: left; margin: 10px 0 0;"
                                            align="left">Thank you for shopping with us!</h3>
                                    </td>
                                    <td class="content-block"
                                        style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;"
                                        valign="top">

                                        <h3 class="aligncenter"
                                            style="font-family: 'Helvetica Neue',Helvetica,Arial,'Lucida Grande',sans-serif; box-sizing: border-box; font-size: 12px; color: #666f7b; line-height: 1.2em; font-weight: 400; text-align: left; margin: 40px 0 0; "
                                            align="left"><b>Order Date:</b> {{date('M d, Y',strtotime($r->created_at))}}</h3>
                                        <h3 class="aligncenter"
                                            style="font-family: 'Helvetica Neue',Helvetica,Arial,'Lucida Grande',sans-serif; box-sizing: border-box; font-size: 12px; color: #666f7b; line-height: 1.2em; font-weight: 400; text-align: left; margin: 10px 0 0;"
                                            align="left"><b>Order Number:</b> {{$r->id}}</h3>
	                                    <h3 class="aligncenter"
                                            style="font-family: 'Helvetica Neue',Helvetica,Arial,'Lucida Grande',sans-serif; box-sizing: border-box; font-size: 12px; color: #666f7b; line-height: 1.2em; font-weight: 400; text-align: left; margin: 10px 0 0;"
                                            align="left"><b>Order Status:</b> {!! $r->payment_status !!}</h3>
                                    </td>
                                </tr>
                                <tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                    <td colspan="2" class="content-block aligncenter"
                                        style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; text-align: center; margin: 0; padding: 0 0 20px;"
                                        align="center" valign="top">
                                        <table class="invoice"
                                               style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; text-align: left; width: 100%; margin: 40px auto;">
                                            <tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                                <td style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 5px 0; "
                                                    valign="top"><b>SHIP TO</b><br
                                                        style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"/>{{$r->shipping->ship_name}}<br
                                                            style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"/>{{$r->shipping->ship_street}}, {{$r->shipping->ship_address}}, <br>{{$r->shipping->ship_city}}, {{$r->shipping->ship_state}}, {{$r->shipping->ship_country}} - {{$r->shipping->ship_postcode}}
                                                    <br
                                                            style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"/>Phone: {{$r->shipping->ship_phone}}
                                                </td>
												<td style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 5px 0;"
                                                    valign="top"><b>BILL To</b><br
                                                        style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"/>{{userinfo($r->user_id,'name') .' '. userinfo($r->user_id,'last_name')}}
                                                    </span> <br>
                                                    {{userinfo($r->user_id,'street')}}, {{userinfo($r->user_id,'address')}}
                                                    <br> {{userinfo($r->user_id,'city')}}, {{userinfo($r->user_id,'state')}}, {{userinfo($r->user_id,'country')}} - {{userinfo($r->user_id,'zipcode')}}
                                                    <br
                                                            style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"/>Phone: {{userinfo($r->user_id,'phone')}}
                                                </td>
                                            </tr>
                                            <tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                                <td colspan="2" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 5px 0;"
                                                    valign="top">
                                                    <table class="invoice-items" cellpadding="0" cellspacing="0"
                                                           style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; margin: 0;">
                                                        <tr class="title"
                                                            style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                                            <td class="alignright"
                                                                style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; text-align: left; border-top-width: 2px; border-top-color: #333; border-top-style: solid; border-bottom-color: #333; border-bottom-width: 2px; border-bottom-style: solid; font-weight: 700; margin: 0; padding: 5px 0;"
                                                                align="right" valign="top">Item
                                                            </td>
														   <td class="alignright"
                                                                style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top;  border-top-width: 2px; border-top-color: #333; border-top-style: solid; border-bottom-color: #333; border-bottom-width: 2px; border-bottom-style: solid; font-weight: 700; margin: 0; padding: 5px 0;"
                                                                align="left" valign="top">Qty
                                                            </td>
                                                            <td class="alignright"
                                                                style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; text-align: right; border-top-width: 2px; border-top-color: #333; border-top-style: solid; border-bottom-color: #333; border-bottom-width: 2px; border-bottom-style: solid; font-weight: 700; margin: 0; padding: 5px 0;"
                                                                align="right" valign="top">Total
                                                            </td>
                                                        </tr>

                                                        @if(!empty($r->order_details))
                                                        @foreach($r->order_details as $ord)
                                                       
														<tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                                            <td style="width:71%;font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; vertical-align: top; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 5px 10px;"
                                                                valign="top"><b>{{$ord->product_name}}</b>
                                                                
                                                            </td>
															 <td class="alignright"
                                                                style="width:100%;font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; text-align: left; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 5px 0;"
                                                                align="right" valign="top">
                                                                <b>{{$ord->qty}}</b>     
                                                               
                                                                
                                                            </td>
                                                            <td class="alignright"
                                                                style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; text-align: right; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 5px 0; width: 500px !important;"
                                                                align="right" valign="top">{!! currency() !!}{{number_format($ord->price * $ord->qty,2)}}
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                        @endif
                                                        

                                                        <tr class="total"
                                                            style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                                            <td  colspan="2" class="alignright"
                                                                style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; text-align: right; border-top-width: 2px; border-top-color: #333; border-top-style: solid; border-bottom-color: #333; border-bottom-width: 2px; border-bottom-style: solid; font-weight: 700; margin: 0; padding: 5px 10px;"
                                                                align="right" valign="top">Total
                                                            </td>
                                                            

                                                            <td class="alignright"
                                                                style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; text-align: right; border-top-width: 2px; border-top-color: #333; border-top-style: solid; border-bottom-color: #333; border-bottom-width: 2px; border-bottom-style: solid; font-weight: 700; margin: 0; padding: 5px 0;"
                                                                align="right" valign="top">{!! currency() !!}{{number_format($r->total - $r->tax,2)}}
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>


                                <tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                    <td colspan="2" class="content-block"
                                        style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;"
                                        valign="top">
									    <table class="invoice"
                                               style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; text-align: left; width: 100%; margin: 0px auto;">

                                            <tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                                <td style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 5px 0; "
                                                    valign="top"><b>Notes:</b><br
                                                        style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"/>
                                                    All accounts are to be paid within 7 days <br
                                                            style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"/>
                                                </td>
												<td style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 5px 0;"
                                                    valign="top"><b><b>Sub-Total:</b> {!! currency() !!}
                                                    <?php $subttoal = $r->total -  $r->tax - $r->deliver_charge ?>
                                                    {{number_format($subttoal,2)}} </b>
                                                    @if($r->discount!="")
                                                    <br
                                                        style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0; color:red;"/><b style="color:red;">Discount:</b> <span style="color:red;"> {!! currency() !!}{{number_format($r->discount,2)}}</span>
                                                    @endif                                                        
                                                    
                                                    <br
                                                        style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"/><b>Tax:</b> {!! currency() !!}{{number_format($r->tax,2)}}
                                                        <br
                                                        style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"/><b>Deliver Charge:</b> {!! currency() !!}{{number_format($r->deliver_charge,2)}}
                                                </td>
                                            </tr>
									    </table>
                                    </td>
                                </tr>


                            </table>
                        </td>
                    </tr>
                </table>

            </div>
        </td>
        <td style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;"
            valign="top"></td>
    </tr>
</table>
</body>
</html>
