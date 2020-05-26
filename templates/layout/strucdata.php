<?php if($template=='product_detail') { ?>
    <!-- Sản phẩm -->
    <script type="application/ld+json">
        {
            "@context": "https://schema.org/",
            "@type": "Product",
            "name": "<?=$row_detail['ten'.$lang]?>",
            "image":
            [
                "<?=$config_base._upload_product_l.$row_detail['photo']?>"
            ],
            "description": "<?=$description_bar?>",
            "sku":"SP0<?=$row_detail['id']?>",
            "mpn": "925872",
            "brand":
            {
                "@type": "Thing",
                "name": "<?=($pro_list['ten'.$lang]!='')?$pro_list['ten'.$lang]:$setting['ten'.$lang]?>"
            },
            "review":
            {
                "@type": "Review",
                "reviewRating":
                {
                    "@type": "Rating",
                    "ratingValue": "5",
                    "bestRating": "5"
                },
                "author":
                {
                    "@type": "Person",
                    "name": "<?=$setting['ten'.$lang]?>"
                }
            },
            "aggregateRating":
            {
                "@type": "AggregateRating",
                "ratingValue": "4.4",
                "reviewCount": "89"
            },
            "offers":
            {
                "@type": "Offer",
                "url": "<?=getCurrentPageURL_CANO()?>",
                "priceCurrency": "VND",
                "price": "<?=$row_detail['gia']?>",
                "priceValidUntil": "2020-11-05",
                "itemCondition": "https://schema.org/UsedCondition",
                "availability": "https://schema.org/InStock",
                "seller":
                {
                    "@type": "Organization",
                    "name": "Executive Objects"
                }
            }
        }
    </script>
<?php } else if($template=='news_detail') { ?>
    <!-- Bài viết -->
    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "NewsArticle",
            "mainEntityOfPage":
            {
                "@type": "WebPage",
                "@id": "https://google.com/article"
            },
            "headline": "<?=$row_detail['ten'.$lang]?>",
            "image":
            [
                "<?=$config_base._upload_news_l.$row_detail['photo']?>"
            ],
            "datePublished": "<?=date('Y-m-d',$row_detail['ngaytao'])?>",
            "dateModified": "<?=date('Y-m-d',$row_detail['ngaytao'])?>",
            "author":
            {
                "@type": "Person",
                "name": "<?=$setting['ten'.$lang]?>"
            },
            "publisher":
            {
                "@type": "Organization",
                "name": "Google",
                "logo":
                {
                    "@type": "ImageObject",
                    "url": "<?=$config_base._upload_photo_l.$logo['photo']?>"
                }
            },
            "description": "<?=$description_bar?>"
        }
    </script>
<?php } else if($template=='static') { ?>
    <!-- Bài viết tĩnh -->
    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "NewsArticle",
            "mainEntityOfPage":
            {
                "@type": "WebPage",
                "@id": "https://google.com/article"
            },
            "headline": "<?=$static['ten'.$lang]?>",
            "image":
            [
                "<?=$config_base._upload_photo_l.$static['photo']?>"
            ],
            "datePublished": "<?=date('Y-m-d',$static['ngaytao'])?>",
            "dateModified": "<?=date('Y-m-d',$static['ngaytao'])?>",
            "author":
            {
                "@type": "Person",
                "name": "<?=$setting['ten'.$lang]?>"
            },
            "publisher":
            {
                "@type": "Organization",
                "name": "Google",
                "logo":
                {
                    "@type": "ImageObject",
                    "url": "<?=$config_base._upload_photo_l.$logo['photo']?>"
                }
            },
            "description": "<?=$description_bar?>"
        }
    </script>
<?php } else { ?>
    <!-- Cấu trúc chung -->
    <script type="application/ld+json">
        {
            "@context" : "https://schema.org",
            "@type" : "Organization",
            "name" : "<?=$setting['ten'.$lang]?>",
            "url" : "<?=$config_base?>",
            "sameAs" :
            [
                <?php $sum_mxh = count($mxh); foreach ($mxh as $key => $value) { ?>
                    "<?=$value['link']?>"<?=(($key+1)<$sum_mxh)?',':''?>
                <?php } ?>
            ],
            "address":
            {
                "@type": "PostalAddress",
                "streetAddress": "<?=$setting['diachi']?>",
                "addressRegion": "Ho Chi Minh",
                "postalCode": "70000",
                "addressCountry": "vi"
            }
        }
    </script>
<?php } ?>