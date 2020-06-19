<?php

require_once("core/db.php");

$cart = JSON::load("php://input");

$total = 0;
$IDs = [];
foreach($cart as $id=>$count) $IDs[] = $id;

$models = $mySQL->getGroup("
SELECT
	name,
	label,
	sticker,
	selling,
	preview,
	currency,
	discount,
	DiscountID,
	gb_items.ItemID AS ItemID,
	gb_items.PageID AS PageID
FROM gb_items
CROSS JOIN gb_models USING(PageID)
LEFT JOIN gb_discounts USING(DiscountID) 
WHERE gb_items.ItemID IN (".implode(",",$IDs).")");

$handle = "b".time();

?>
<div id="<?=$handle?>" class="box" onreset="boxList.drop()" onclick="event.cancelBubble=true" style="width:980px;">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<div class="box-title">
		<span data-translate="textContent">cart</span>
		<span class="close-btn" onclick="boxList.drop()" type="reset">✕</span>
	</div>
	<div id="cart-body" class="box-body">
		<div id="order-body">
			<table width="100%" cellspacing="0" rules="rows" bordercolor="#CCC">
				<thead>
					<tr>
						<th></th>
						<th data-translate="textContent">named</th>
						<th data-translate="textContent">amount</th>
						<th data-translate="textContent">price</th>
						<th data-translate="textContent">sum</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?foreach($models['ItemID'] as $i=>$id):
          			$discount = 0;
          			$models['selling'][$i] *= $config->{$models['currency'][$i]};
          			if($models['DiscountID'][$i] && $models['discount'][$i]){
            			$discount = floor($models['selling'][$i] * $models['discount'][$i] / 100);
          			}
          			$price = $models['selling'][$i] - $discount;
          			$total += $sum = $price * $cart[$models['ItemID'][$i]]?>
          			<tr>
						<td><img width="128" src="<?=$models['preview'][$i]?>"></td>
						<th align="left">
							<div class="code"><tt><span class="gold" data-translate="textContent">code</span>:<?=($models['PageID'][$i].'-'.$models['ItemID'][$i])?></tt></div>
							<?=($models['name'][$i].' - '.$models['label'][$i])?>
						</th>
						<td align="center">
							<div class="counter" title="amount" data-translate="title">
								<label onclick="this.next('input').stepDown()">&#9664;</label>
								<input name="count" data-id="<?=$models['ItemID'][$i]?>" data-price="<?=money_format("%i", $price)?>" type="number" min="1" value="<?=$cart[$models['ItemID'][$i]]?>" required readonly placeholder="0">
								<label onclick="this.previous('input').stepUp()">&#9654;</label>
							</div>
						</td>
						<td class="price"><?=money_format("%i", $price)?> грн.</td>
						<th class="item-sum"><?=money_format("%i", $sum)?> грн.</th>
						<td align="right">
							<button class="drop-btn" title="remove" data-translate="title" data-id="<?=$models['ItemID'][$i]?>">✕</button>
						</td>
					</tr>
					<?endforeach?>
					<script>
					(function(body){
						body.selector(".drop-btn", true).forEach(function(btn){
							btn.onclick=function(){
								body.removeChild(btn.parent(2));
								var cart = JSON.parse(window.localStorage.cart || "{}");
								delete(cart[btn.dataset.id]);
								recalculate();
							}
						});
						var recalculate=function(){
                			var total = 0, sum = 0, cart = {},

							sumfields = body.selector("th.item-sum", true);
							body.selector("input", true).forEach(function(inp, i){
								cart[inp.dataset.id] = inp.value;
								total += sum = (inp.value * inp.dataset.price);
								sumfields[i].textContent = sum.toFixed(2)+" грн.";
							});

							var count = Object.keys(cart).length;
							if(count){
								window.localStorage.cart = JSON.encode(cart);
							}else window.localStorage.cart = '{}';
							doc.querySelector("#cart-btn").dataset.count = count;
                
							body.parentNode.selector("tfoot>tr>td>b", false).innerHTML = total.toFixed(2);
						}
						body.selector(".counter>label", true).forEach(function(btn, i){
							btn.onclick = function(){
								if(i%2){
									btn.previous('input').stepUp();
								}else btn.next('input').stepDown();
								recalculate();
							}
						});
					})(document.currentScript.parentNode);
					</script>
				</tbody>
				<tfoot><tr><td colspan="6" align="right"><span data-translate="textContent">Сумма</span>: <b><?=money_format("%i", $total)?></b> грн.</td></tr></tfoot>
			</table>
		</div>
		<form id="order">
			<div>
				<fieldset>
					<sup class="red-txt">*</sup><span data-translate="textContent">phone</span>:
					<input name="phone" placeholder="(000) 000-0000" required>
					<sup class="red-txt">*</sup><span data-translate="textContent">name</span>:
					<input name="fullname" placeholder="..." required>
					<span>Email</span>:
					<input name="email" placeholder="...">
				</fieldset>
			</div>
			<div>
				<input id="reserved" type="radio" name="orderType" value="reserved" checked hidden> 
				<label for="reserved">Самовывоз с Героев Сталинграда (Киев)</label>

				<input id="delivery" type="radio" name="orderType" value="delivery" hidden>
				<label for="delivery" class="red">Доставка Новой Почтой</label>
            
				<fieldset>
					<input name="city" placeholder="city" data-translate="placeholder">
					<input name="office" placeholder="branch number" data-translate="placeholder">
					<span data-translate="textContent">payment</span>:
					<input id="card" type="radio" name="payment" value="card" checked hidden>
					<label for="card" data-translate="textContent">credit card</label>

					<input id="on-delivery" type="radio" name="payment" value="on delivery" hidden>
					<label for="on-delivery" data-translate="textContent">on delivery</label>
				</fieldset>
				<button form="order" type="submit" class="green" data-translate="textContent">send order</button>
				<button form="order" type="reset" class="dark" data-translate="textContent">cancel</button>
			</div>
			<script>
			(function(form){
				var timeout;
				form.phone.oninput=function(){
					var phone = this.value.replace(/\D/g, "").replace(/^38/, "");
					clearTimeout(timeout);
					timeout = setTimeout(function(){
						if(phone.length<10) return true;
						XHR.push({
							"addressee":"/xhr/search/client/"+phone,
							"onsuccess":function(response){
								response = JSON.parse(response);
								if(response && parseInt(response['status'])){
									form.fullname.value = response.citizen['Name'];
									form.email.value = response.citizen['Email'];
								}else{
									form.fullname.value = "";
									form.email.value = "";
								}
							}
						});
					},1000);
				}
				form.onsubmit=function(event){
					event.preventDefault();
					XHR.push({
						addressee:"/xhr/forms/order",
						body:JSON.encode({
							"name":form.fullname.value.trim(),
							"phone":form.phone.value.replace(/\D/g, "").replace(/^38/, ""),
							"email":form.email.value.trim(),
							"type":form.orderType.value,
							"city":form.city.value.trim(),
							"office":form.office.value.trim(),
							"payment":form.payment.value.trim(),
							"cart":JSON.parse(window.localStorage.cart || "{}")
						}),
						onsuccess:function(response){
							if(parseInt(response)){
							// Реакция на успешное добавление заказа
								window.localStorage.cart = "{}";
								document.querySelector("#cart-btn").dataset.count=0;
								boxList.drop()
							}else{} // Реакция на неудачу
						}
					});
				}
				form.onreset=function(event){ event.preventDefault() }
			})(document.currentScript.parentNode)
			</script>
		</form>
	</div>
	<script>
	(function(box){
		if(box.offsetHeight>(screen.height-80)){
			box.style.top="10px";
		}else box.style.top = "calc(50% - "+(box.offsetHeight / 2)+"px)";
	})(document.currentScript.parentNode)
	</script>
</div>