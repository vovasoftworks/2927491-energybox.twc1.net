<?xml version="1.0" encoding="utf-8"?>
<!DOCTYPE xsl:stylesheet SYSTEM "lang://56">
<xsl:stylesheet version="1.0"
	xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
	xmlns:hostcms="http://www.hostcms.ru/"
	exclude-result-prefixes="hostcms">
	<xsl:output xmlns="http://www.w3.org/TR/xhtml1/strict" doctype-public="-//W3C//DTD XHTML 1.0 Strict//EN" encoding="utf-8" indent="yes" method="html" omit-xml-declaration="no" version="1.0" media-type="text/xml"/>

	<!-- МагазинТовар -->

	<xsl:decimal-format name="my" decimal-separator="," grouping-separator=" "/>

	<xsl:template match="/shop">

<script type='text/javascript' id='wc-single-product-js-extra'>
/* <![CDATA[ */
var wc_single_product_params = {"tabs_enabled":"1"};
/* ]]> */
</script>


<style>
#theme-page-header .page-header, #theme-page-header .no-page-brecbrumd {
background-color: #f6f6f6;
}

.single-gallery-slider .single-product-gallery {
position: relative;
min-height: 1px;
float: left;
}

@media (min-width: 1200px){
.single-gallery-slider.single-gallery-horizontal .single-product-gallery {
width: 600px;
}
}
</style>







<div class="single-product single-gallery-slider single-gallery-horizontal">
<div class="shop-container container with-full-sidebar has-flexible-sidebar">
		<div class="shop-content">
		
			<xsl:apply-templates select="shop_item"/>		
			

		
			</div>
				</div>
</div>


		

<script type='text/javascript' src='/assets/wp-content/plugins/woocommerce/assets/js/frontend/single-product.js?ver=5.2.2' id='wc-single-product-js'></script>
	</xsl:template>

	<xsl:template match="shop_item">


<div class="woocommerce-notices-wrapper"></div>
			<div id="product-319" class="product type-product post-319 status-publish first instock product_cat-service-kits product_cat-suspension product_cat-trending product_tag-bmw product_tag-car has-post-thumbnail sale shipping-taxable purchasable product-type-simple">

			<div class="wrapper-product-content">
		
			<!--<span class="onsale">
			Sale !		</span>-->
		
		<div class="single-product-gallery pro-single-image">
				<div class="pro-carousel-image">

			<xsl:variable name="imgPath">
			<xsl:choose>
				<xsl:when test="image_large!=''">
				<xsl:value-of select="dir" /><xsl:value-of select="image_small" />
				</xsl:when>
				<xsl:otherwise>
				/assets/wp-content/uploads/no-image.png
				</xsl:otherwise>
			</xsl:choose>
		</xsl:variable>

	<img src="{$imgPath}" class="loaded tns-complete" />			
			
		</div>

							<!--<div class="pro-carousel-thumb">
				<div class="tns-outer" id="gallery-thumb-ow"><div class="tns-liveregion tns-visually-hidden" aria-live="polite" aria-atomic="true">slide <span class="current">1 to 2</span>  of 2</div>
				<div id="gallery-thumb-mw" class="tns-ovh"><div class="tns-inner" id="gallery-thumb-iw"><div class="tns-outer" id="gallery-thumb-ow"><div class="tns-controls" aria-label="Carousel Navigation" tabindex="0" style="display: none;"><button data-controls="prev" tabindex="-1" aria-controls="gallery-thumb">prev</button><button data-controls="next" tabindex="-1" aria-controls="gallery-thumb">next</button></div><div class="tns-liveregion tns-visually-hidden" aria-live="polite" aria-atomic="true">slide <span class="current">1 to 2</span>  of 2</div><div id="gallery-thumb-mw" class="tns-ovh"><div class="tns-inner" id="gallery-thumb-iw"><div id="gallery-thumb" class="  tns-slider tns-carousel tns-subpixel tns-calc tns-horizontal  tns-slider tns-carousel tns-subpixel tns-calc tns-horizontal" style="transition-duration: 0s; transform: translate3d(0%, 0px, 0px);" aria-label="Carousel Pagination">
					<div class="pro-thumb tns-item tns-slide-active tns-nav-active" id="gallery-thumb-item0" data-nav="0" aria-label="Carousel Page 1 (Current Slide)" aria-controls="gallery-image">
						<img src="http://apar/wp-content/uploads/2020/06/pngwing-1-150x150.jpg" alt="Product image" />
					</div>

											<div class="pro-thumb tns-item tns-slide-active" id="gallery-thumb-item1" data-nav="1" tabindex="-1" aria-label="Carousel Page 2" aria-controls="gallery-image">
							<img src="http://apar/wp-content/uploads/2020/06/tire-6-150x150.jpg" alt="Product image" />
						</div>
									</div></div></div></div></div></div></div>
			</div>-->
				</div>
	
	
	
	<div class="summary entry-summary">
		<h1 class="product_title entry-title"><xsl:value-of select="name"/></h1>




		<p class="price">
			<span class="woocs_price_code" data-product-id="319">
			<xsl:if test="price != 0">
				<xsl:if test="discount != 0">
				<del>
				<span class="woocommerce-Price-amount amount">
				<bdi><xsl:value-of select="format-number(price + discount, '### ##0', 'my')"/><xsl:text> </xsl:text><span class="woocommerce-Price-currencySymbol"><xsl:value-of select="currency" /></span></bdi>
				</span>
				</del>
				</xsl:if>
				
				<ins>
				<span class="woocommerce-Price-amount amount">
				<bdi><xsl:value-of select="format-number(price, '### ##0', 'my')"/><xsl:text> </xsl:text><span class="woocommerce-Price-currencySymbol"><xsl:value-of select="currency"/></span></bdi>
				</span>
				</ins>
			</xsl:if>
			</span>
			
		</p>
<div class="woocommerce-product-details__short-description"></div>

	
	<form class="cart" action="" method="post" enctype="multipart/form-data">
		
			<div class="quantity"><span class="modify-qty" data-click="minus"></span>
				<label class="screen-reader-text" for="quantity_60788ea74069a">Количество</label>
		<input type="number" id="quantity_60788ea74069a" class="input-text qty text" step="1" min="1" max="80" name="quantity" value="1" title="Кол-во" size="4" placeholder="" inputmode="numeric" />
			<span class="modify-qty" data-click="plus"></span></div>
	
		<button type="button" onclick="return $.addIntoCart('{/shop/url}cart/', {@id}, 1)" name="add-to-cart" value="319" class="single_add_to_cart_button button alt">В корзину</button>


	<input class="in-cart-qty" type="hidden" value="0" data-in_stock="no" />
	
	</form>

	
	<div class="product_meta">
				
		<span class="posted_in meta_detail">
		<strong><xsl:value-of select="../shop_item_properties/property[@id=113]/name"/>:&#xA0;</strong> 
		<xsl:value-of select="property_value[property_id=113]/value"/>
		</span>
		
		<span class="posted_in meta_detail">
		<strong><xsl:value-of select="../shop_item_properties/property[@id=114]/name"/>:&#xA0;</strong> 
		<xsl:value-of select="property_value[property_id=114]/value"/>
		</span>

		<span class="posted_in meta_detail">
		<strong><xsl:value-of select="../shop_item_properties/property[@id=115]/name"/>:&#xA0;</strong> 
		<xsl:value-of select="property_value[property_id=115]/value"/>
		</span>

		<span class="posted_in meta_detail">
		<strong><xsl:value-of select="../shop_item_properties/property[@id=116]/name"/>:&#xA0;</strong> 
		<xsl:value-of select="property_value[property_id=116]/value"/>
		</span>

<span class="posted_in meta_detail">
		<strong><xsl:value-of select="../shop_item_properties/property[@id=117]/name"/>:&#xA0;</strong> 
		<xsl:value-of select="property_value[property_id=117]/value"/>
		</span>

	</div>
		</div>

			</div>
		
	<div class="woocommerce-tabs wc-tabs-wrapper">
		<ul class="tabs wc-tabs" role="tablist">
							<li class="description_tab active" id="tab-title-description" role="tab" aria-controls="tab-description">
					<a href="#tab-description">
						Описание					</a>
				</li>
							<li class="additional_information_tab" id="tab-title-additional_information" role="tab" aria-controls="tab-additional_information">
					<a href="#tab-additional_information">
						Характеристики					</a>
				</li>
			
		
	
					</ul>
		
		
		<div class="woocommerce-Tabs-panel woocommerce-Tabs-panel--description panel entry-content wc-tab" id="tab-description" role="tabpanel" aria-labelledby="tab-title-description" style="display: block;">
			<xsl:value-of disable-output-escaping="yes" select="text" />	
			</div>
					<div class="woocommerce-Tabs-panel woocommerce-Tabs-panel--additional_information panel entry-content wc-tab" id="tab-additional_information" role="tabpanel" aria-labelledby="tab-title-additional_information" style="display: none;">



		<xsl:if test="count(property_value)">
				<table class="woocommerce-product-attributes shop_attributes">
			<tbody>
				<xsl:apply-templates select="property_value"/>
			</tbody></table>
			</xsl:if>			

	
			</div>


		
			</div>


	</div>


	</xsl:template>

	<!-- Шаблон для товара просмотренные -->
	<xsl:template match="shop_item" mode="view">
		<div class="shop_item">
			<div class="shop_table_item">
				<div class="image_row">
					<div class="image_cell">
						<a href="{url}">
							<xsl:choose>
								<xsl:when test="image_small != ''">
									<img src="{dir}{image_small}" alt="{name}" title="{name}"/>
								</xsl:when>
								<xsl:otherwise>
									<img src="/images/no-image.png" alt="{name}" title="{name}"/>
								</xsl:otherwise>
							</xsl:choose>
						</a>
					</div>
				</div>
				<div class="description_row">
					<div class="description_sell">
						<p>
							<a href="{url}" title="{name}" hostcms:id="{@id}" hostcms:field="name" hostcms:entity="shop_item">
								<xsl:value-of select="name"/>
							</a>
						</p>
						<div class="price">
						<xsl:value-of select="format-number(price, '### ##0,00', 'my')"/><xsl:text> </xsl:text><xsl:value-of select="currency"/><xsl:text> </xsl:text>
							<!-- Ссылку на добавление в корзины выводим, если:
							type = 0 - простой тип товара
							type = 1 - электронный товар, при этом остаток на складе больше 0 или -1,
							что означает неограниченное количество -->
							<xsl:if test="type = 0 or (type = 1 and (digitals > 0 or digitals = -1))">
								<a href="{/shop/url}cart/?add={@id}" onclick="return $.addIntoCart('{/shop/url}cart/', {@id}, 1)">
									<img src="/images/add_to_cart.gif" alt="&labelAddIntoCart;" title="&labelAddIntoCart;" />
								</a>
							</xsl:if>

							<!-- Сравнение товаров -->
							<xsl:variable name="shop_item_id" select="@id" />
							<div class="compare" onclick="return $.addCompare('{/shop/url}', {@id}, this)">
								<xsl:if test="/shop/comparing/shop_item[@id = $shop_item_id]/node()">
									<xsl:attribute name="class">compare current</xsl:attribute>
								</xsl:if>
							</div>
							<!-- Избранное -->
							<div class="favorite" onclick="return $.addFavorite('{/shop/url}', {@id}, this)">
								<xsl:if test="/shop/favorite/shop_item[@id = $shop_item_id]/node()">
									<xsl:attribute name="class">favorite favorite_current</xsl:attribute>
								</xsl:if>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<xsl:if test="position() mod 3 = 0 and position() != last()">
			<span class="table_row"></span>
		</xsl:if>
	</xsl:template>

	<!-- Show property item -->
	<xsl:template match="property_value">
	
		<xsl:if test="value/node() and value != '' or file/node() and file != ''">
			<tr class="woocommerce-product-attributes-item">

				<xsl:variable name="property_id" select="property_id" />
				<xsl:variable name="property" select="/shop/shop_item_properties//property[@id=$property_id]" />

				<th class="woocommerce-product-attributes-item__label"><xsl:value-of select="$property/name"/><xsl:text>: </xsl:text></th>
				<td class="woocommerce-product-attributes-item__value"><xsl:choose>
						<xsl:when test="$property/type = 2">
							<a href="{../dir}{file}" target="_blank"><xsl:value-of select="file_name"/></a>
						</xsl:when>
						<xsl:when test="$property/type = 5">
							<a href="{informationsystem_item/url}"><xsl:value-of select="informationsystem_item/name"/></a>
						</xsl:when>
						<xsl:when test="$property/type = 7">
							<input type="checkbox" disabled="disabled">
								<xsl:if test="value = 1">
									<xsl:attribute name="checked">checked</xsl:attribute>
								</xsl:if>
							</input>
						</xsl:when>
						<xsl:when test="$property/type = 12">
							<a href="{shop_item/url}"><xsl:value-of select="shop_item/name"/></a>
						</xsl:when>
						<xsl:otherwise>
							<xsl:value-of disable-output-escaping="yes" select="value"/>
							<!-- Единица измерения свойства -->
							<xsl:if test="$property/shop_measure/node()">
								<xsl:text> </xsl:text><xsl:value-of select="$property/shop_measure/name"/>
							</xsl:if>
						</xsl:otherwise>
				</xsl:choose></td>
			</tr>
		</xsl:if>
	</xsl:template>

	<!-- Tag Template -->
	<xsl:template match="tag">
		<a href="{/shop/url}tag/{urlencode}/" class="tag">
			<xsl:value-of select="name"/>
		</a>
	<xsl:if test="position() != last()"><xsl:text>, </xsl:text></xsl:if>
	</xsl:template>

	<!-- Шаблон для модификаций -->
	<xsl:template match="modifications/shop_item">
		<li>
			<!-- Название модификации -->
			<a href="{url}"><xsl:value-of select="name"/></a>,
			<!-- Цена модификации -->
			<xsl:value-of select="price"/><xsl:text> </xsl:text><xsl:value-of disable-output-escaping="yes" select="currency"/>
		</li>
	</xsl:template>

	<!-- Шаблон для сопутствующих товаров -->
	<xsl:template match="associated/shop_item">
		<li>
			<!-- Название сопутствующего товара -->
			<a href="{url}"><xsl:value-of select="name"/></a>,
			<!-- Цена сопутствующего товара -->
			<xsl:value-of select="price"/><xsl:text> </xsl:text><xsl:value-of disable-output-escaping="yes" select="currency"/>
		</li>
	</xsl:template>

	<!-- Star Rating -->
	<xsl:template name="show_average_grade">
		<xsl:param name="grade" select="0"/>
		<xsl:param name="const_grade" select="0"/>

		<!-- To avoid loops -->
		<xsl:variable name="current_grade" select="$grade * 1"/>

		<xsl:choose>
			<!-- If a value is an integer -->
			<xsl:when test="floor($current_grade) = $current_grade and not($const_grade &gt; ceiling($current_grade))">

				<xsl:if test="$current_grade - 1 &gt; 0">
					<xsl:call-template name="show_average_grade">
						<xsl:with-param name="grade" select="$current_grade - 1"/>
						<xsl:with-param name="const_grade" select="$const_grade - 1"/>
					</xsl:call-template>
				</xsl:if>

				<xsl:if test="$current_grade != 0">
					<img src="/images/star-full.png"/>
				</xsl:if>
			</xsl:when>
			<xsl:when test="$current_grade != 0 and not($const_grade &gt; ceiling($current_grade))">

				<xsl:if test="$current_grade - 0.5 &gt; 0">
					<xsl:call-template name="show_average_grade">

						<xsl:with-param name="grade" select="$current_grade - 0.5"/>
						<xsl:with-param name="const_grade" select="$const_grade - 1"/>
					</xsl:call-template>
				</xsl:if>

				<img src="/images/star-half.png"/>
			</xsl:when>

			<!-- Show the gray stars until the current position does not reach the value increased to an integer -->
			<xsl:otherwise>
				<xsl:call-template name="show_average_grade">
					<xsl:with-param name="grade" select="$current_grade"/>
					<xsl:with-param name="const_grade" select="$const_grade - 1"/>
				</xsl:call-template>
				<img src="/images/star-empty.png"/>
			</xsl:otherwise>
		</xsl:choose>
	</xsl:template>

	<!-- Шаблон для вывода звездочек (оценки) -->
	<xsl:template name="for">
		<xsl:param name="i" select="0"/>
		<xsl:param name="n"/>

		<input type="radio" name="shop_grade" value="{$i}" id="id_shop_grade_{$i}">
			<xsl:if test="/shop/shop_grade = $i">
				<xsl:attribute name="checked"></xsl:attribute>
			</xsl:if>
	</input><xsl:text> </xsl:text>
		<label for="id_shop_grade_{$i}">
			<xsl:call-template name="show_average_grade">
				<xsl:with-param name="grade" select="$i"/>
				<xsl:with-param name="const_grade" select="5"/>
			</xsl:call-template>
		</label>
		<br/>
		<xsl:if test="$n &gt; $i and $n &gt; 1">
			<xsl:call-template name="for">
				<xsl:with-param name="i" select="$i + 1"/>
				<xsl:with-param name="n" select="$n"/>
			</xsl:call-template>
		</xsl:if>
	</xsl:template>

	<!-- Review template -->
	<xsl:template match="comment">
		<!-- Text or subject is not empty -->
		<xsl:if test="text != '' or subject != ''">
			<a name="comment{@id}"></a>
			<div class="comment" id="comment{@id}">
				<xsl:if test="subject != ''">
					<div class="subject" hostcms:id="{@id}" hostcms:field="subject" hostcms:entity="comment"><xsl:value-of select="subject"/></div>
				</xsl:if>

				<div hostcms:id="{@id}" hostcms:field="text" hostcms:entity="comment" hostcms:type="wysiwyg"><xsl:value-of select="text" disable-output-escaping="yes"/></div>

				<p class="tags">
					<!-- Grade -->
					<xsl:if test="grade != 0">
						<span><xsl:call-template name="show_average_grade">
								<xsl:with-param name="grade" select="grade"/>
								<xsl:with-param name="const_grade" select="5"/>
						</xsl:call-template></span>
					</xsl:if>

					<img src="/images/user.png" />
					<xsl:choose>
						<!-- Review was added an authorized user -->
						<xsl:when test="count(siteuser) &gt; 0">
						<span><a href="/users/info/{siteuser/path}/"><xsl:value-of select="siteuser/login"/></a></span>
						</xsl:when>
						<!-- Review was added an unauthorized user -->
						<xsl:otherwise>
							<span><xsl:value-of select="author" /></span>
						</xsl:otherwise>
					</xsl:choose>

					<xsl:if test="rate/node()">
						<span id="comment_id_{@id}" class="thumbs">
							<xsl:choose>
								<xsl:when test="/shop/siteuser_id > 0">
									<xsl:choose>
										<xsl:when test="vote/value = 1">
											<xsl:attribute name="class">thumbs up</xsl:attribute>
										</xsl:when>
										<xsl:when test="vote/value = -1">
											<xsl:attribute name="class">thumbs down</xsl:attribute>
										</xsl:when>
									</xsl:choose>

									<span id="comment_likes_{@id}"><xsl:value-of select="rate/@likes" /></span>
									<span class="inner_thumbs">
										<a onclick="return $.sendVote({@id}, 1, 'comment')" href="{/shop/url}?id={@id}&amp;vote=1&amp;entity_type=comment" alt="&labelLike;"></a>
										<span class="rate" id="comment_rate_{@id}"><xsl:value-of select="rate" /></span>
										<a onclick="return $.sendVote({@id}, 0, 'comment')" href="{/shop/url}?id={@id}&amp;vote=0&amp;entity_type=comment" alt="&labelDislike;"></a>
									</span>
									<span id="comment_dislikes_{@id}"><xsl:value-of select="rate/@dislikes" /></span>
								</xsl:when>
								<xsl:otherwise>
									<xsl:attribute name="class">thumbs inactive</xsl:attribute>
									<span id="comment_likes_{@id}"><xsl:value-of select="rate/@likes" /></span>
									<span class="inner_thumbs">
										<a alt="&labelLike;"></a>
										<span class="rate" id="comment_rate_{@id}"><xsl:value-of select="rate" /></span>
										<a alt="&labelDislike;"></a>
									</span>
									<span id="comment_dislikes_{@id}"><xsl:value-of select="rate/@dislikes" /></span>
								</xsl:otherwise>
							</xsl:choose>
						</span>
					</xsl:if>

					<img src="/images/calendar.png" /> <span><xsl:value-of select="datetime"/></span>

					<xsl:if test="/shop/show_add_comments/node()
						and ((/shop/show_add_comments = 1 and /shop/siteuser_id > 0)
						or /shop/show_add_comments = 2)">
					<span class="red" onclick="$('.comment_reply').hide('slow');$('#cr_{@id}').toggle('slow')">&labelReply;</span></xsl:if>

				<span class="red"><a href="{/shop/shop_item/url}#comment{@id}" title="&labelCommentLink;">#</a></span>
				</p>
			</div>

			<!-- Only for authorized users -->
			<xsl:if test="/shop/show_add_comments/node() and ((/shop/show_add_comments = 1 and /shop/siteuser_id > 0) or /shop/show_add_comments = 2)">
				<div class="comment_reply" id="cr_{@id}">
					<xsl:call-template name="AddCommentForm">
						<xsl:with-param name="id" select="@id"/>
					</xsl:call-template>
				</div>
			</xsl:if>

			<!-- Child Reviews -->
			<xsl:if test="count(comment)">
				<div class="comment_sub">
					<xsl:apply-templates select="comment"/>
				</div>
			</xsl:if>
		</xsl:if>
	</xsl:template>

	<!-- AddCommentForm Template -->
	<xsl:template name="AddCommentForm">
		<xsl:param name="id" select="0"/>


		<xsl:variable name="subject">
			<xsl:if test="/shop/comment/parent_id/node() and /shop/comment/parent_id/node() and /shop/comment/parent_id= $id">
				<xsl:value-of select="/shop/comment/subject"/>
			</xsl:if>
		</xsl:variable>
		<xsl:variable name="email">
			<xsl:if test="/shop/comment/email/node() and /shop/comment/parent_id/node() and /shop/comment/parent_id= $id">
				<xsl:value-of select="/shop/comment/email"/>
			</xsl:if>
		</xsl:variable>
		<xsl:variable name="phone">
			<xsl:if test="/shop/comment/phone/node() and /shop/comment/parent_id/node() and /shop/comment/parent_id= $id">
				<xsl:value-of select="/shop/comment/phone"/>
			</xsl:if>
		</xsl:variable>
		<xsl:variable name="text">
			<xsl:if test="/shop/comment/text/node() and /shop/comment/parent_id/node() and /shop/comment/parent_id= $id">
				<xsl:value-of select="/shop/comment/text"/>
			</xsl:if>
		</xsl:variable>
		<xsl:variable name="name">
			<xsl:if test="/shop/comment/author/node() and /shop/comment/parent_id/node() and /shop/comment/parent_id= $id">
				<xsl:value-of select="/shop/comment/author"/>
			</xsl:if>
		</xsl:variable>

		<div class="comment">

			<form action="{/shop/shop_item/url}" name="comment_form_0{$id}" method="post">
				<!-- Only for unauthorized users -->
				<xsl:if test="/shop/siteuser_id = 0">

					<div class="row">
						<div class="caption">&labelName;</div>
						<div class="field">
							<input type="text" size="70" name="author" value="{$name}"/>
						</div>
					</div>

					<div class="row">
						<div class="caption">&labelEmail;</div>
						<div class="field">
							<input id="email{$id}" type="text" size="70" name="email" value="{$email}" />
							<div id="error_email{$id}"></div>
						</div>
					</div>

					<div class="row">
						<div class="caption">&labelPhone;</div>
						<div class="field">
							<input type="text" size="70" name="phone" value="{$phone}"/>
						</div>
					</div>
				</xsl:if>

				<div class="row">
					<div class="caption">&labelSubject;</div>
					<div class="field">
						<input type="text" size="70" name="subject" value="{$subject}"/>
					</div>
				</div>

				<div class="row">
					<div class="caption">&labelReview;</div>
					<div class="field">
						<textarea name="text" cols="68" rows="5" class="mceEditor"><xsl:value-of select="$text"/></textarea>
					</div>
				</div>

				<div class="row">
					<div class="caption">&labelGrade;</div>
					<div class="field stars">
						<select name="grade">
							<option value="1">Poor</option>
							<option value="2">Fair</option>
							<option value="3">Average</option>
							<option value="4">Good</option>
							<option value="5">Excellent</option>
						</select>
					</div>
				</div>

				<!-- Showing captcha -->
				<xsl:if test="//captcha_id != 0 and /shop/siteuser_id = 0">
					<div class="row">
						<div class="caption"></div>
						<div class="field">
							<img id="comment_{$id}" class="captcha" src="/captcha.php?id={//captcha_id}{$id}&amp;height=30&amp;width=100" title="&labelCaptchaId;" name="captcha"/>

							<div class="captcha">
								<img src="/images/refresh.png" /> <span onclick="$('#comment_{$id}').updateCaptcha('{//captcha_id}{$id}', 30); return false">&labelUpdateCaptcha;</span>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="caption">
					&labelCaptchaId;<sup><font color="red">*</font></sup>
						</div>
						<div class="field">
							<input type="hidden" name="captcha_id" value="{//captcha_id}{$id}"/>
							<input type="text" name="captcha" size="15"/>
						</div>
					</div>
				</xsl:if>

				<xsl:if test="$id != 0">
					<input type="hidden" name="parent_id" value="{$id}"/>
				</xsl:if>

				<div class="row">
					<div class="caption"></div>
					<div class="field">
						<input id="submit_email{$id}" type="submit" name="add_comment" value="&labelPublish;" class="button" />
					</div>
				</div>
			</form>
		</div>
	</xsl:template>

	<!-- Шаблон для скидки -->
	<xsl:template match="shop_discount">
		<div class="shop_discount">
			<xsl:value-of select="name"/><xsl:text> </xsl:text>
			<span>
				<xsl:choose>
					<xsl:when test="type = 0">
						<xsl:value-of select="percent"/>%
					</xsl:when>
					<xsl:otherwise>
						<xsl:value-of select="amount"/><xsl:text> </xsl:text><xsl:value-of select="/shop/shop_currency/name"/>
					</xsl:otherwise>
				</xsl:choose>
			</span>
		</div>
	</xsl:template>

	<!-- Шаблон выводит хлебные крошки -->
	<xsl:template match="shop_group" mode="breadCrumbs">
		<xsl:variable name="parent_id" select="parent_id"/>

		<!-- Call recursively parent group -->
		<xsl:apply-templates select="//shop_group[@id=$parent_id]" mode="breadCrumbs"/>

		<xsl:if test="parent_id=0">
			<a href="{/shop/url}" hostcms:id="{/shop/@id}" hostcms:field="name" hostcms:entity="shop">
				<xsl:value-of select="/shop/name"/>
			</a>
		</xsl:if>

	<span><xsl:text> → </xsl:text></span>

		<a href="{url}" hostcms:id="{@id}" hostcms:field="name" hostcms:entity="shop_group">
			<xsl:value-of select="name"/>
		</a>
	</xsl:template>

	<!-- Declension of the numerals -->
	<xsl:template name="declension">

		<xsl:param name="number" select="number"/>

		<!-- Nominative case / Именительный падеж -->
	<xsl:variable name="nominative"><xsl:text>&labelNominative;</xsl:text></xsl:variable>

		<!-- Genitive singular / Родительный падеж, единственное число -->
	<xsl:variable name="genitive_singular"><xsl:text>&labelGenitiveSingular;</xsl:text></xsl:variable>

	<xsl:variable name="genitive_plural"><xsl:text>&labelGenitivePlural;</xsl:text></xsl:variable>
		<xsl:variable name="last_digit"><xsl:value-of select="$number mod 10"/></xsl:variable>
		<xsl:variable name="last_two_digits"><xsl:value-of select="$number mod 100"/></xsl:variable>

		<xsl:choose>
			<xsl:when test="$last_digit = 1 and $last_two_digits != 11">
				<xsl:value-of select="$nominative"/>
			</xsl:when>
			<xsl:when test="$last_digit = 2 and $last_two_digits != 12
				or $last_digit = 3 and $last_two_digits != 13
				or $last_digit = 4 and $last_two_digits != 14">
				<xsl:value-of select="$genitive_singular"/>
			</xsl:when>
			<xsl:otherwise>
				<xsl:value-of select="$genitive_plural"/>
			</xsl:otherwise>
		</xsl:choose>
	</xsl:template>
</xsl:stylesheet>