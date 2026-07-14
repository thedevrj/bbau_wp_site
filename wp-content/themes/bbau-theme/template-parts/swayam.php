<?php
/**
 * Template Name: About the Patron
 */
get_header(); ?>

<!-- Banner -->
<?php get_template_part('banners/about-banner'); ?>

<section class="container-fluid page-bg page-template-about-bg py-5 overflow-hidden">

<?php get_template_part('template-parts/breadcrumb'); ?>

<!-- Menu -->
<?php get_template_part('template-parts/page-menu'); ?>

<div class="container">

  <!-- BANNER IMAGE (full width top) -->
  <div style="margin-bottom:30px;">
    <img src="/wp-content/uploads/2026/06/a.jpg"
         alt="Prof. Raj Kumar Mittal"
         style="width:100%; height:auto; display:block;">
  </div>

  <style>
  .profile-wrap {
    width: 100%;
    box-sizing: border-box;
    overflow: hidden;
  }
  .profile-wrap::after {
    content: "";
    display: table;
    clear: both;
  }

  /* Floated image — text wraps beside AND below */
  .profile-float-img {
    float: left;
    width: 45%;
    box-sizing: border-box;
    padding-right: 28px;
    margin-bottom: 10px;
  }
  .profile-float-img img {
    width: 100% !important;
    height: auto !important;
    display: block !important;
  }

  .profile-name {
    text-align: center;
    font-size: 16px !important;
    font-weight: 600 !important;
    line-height: 1.9 !important;
    color: #222 !important;
    font-family: inherit !important;
    margin: 0 0 18px !important;
    padding-bottom: 14px;
    border-bottom: 1px solid #ddd;
  }
  .profile-name strong {
    display: block;
    font-size: 18px !important;
    font-weight: 700 !important;
    color: #8B1A1A !important;
    margin-bottom: 4px;
  }
  .profile-bio {
    font-size: 15px !important;
    line-height: 1.9 !important;
    color: #333 !important;
    text-align: justify;
    margin: 0 !important;
  }
  .profile-bio p {
    margin-bottom: 14px !important;
  }

  /* Tablet */
  @media (max-width: 900px) {
    .profile-float-img {
      width: 45%;
      padding-right: 20px;
    }
    .profile-bio {
      font-size: 13.5px !important;
    }
  }

  /* Mobile: image full width on top, content below */
  @media (max-width: 576px) {
    .profile-float-img {
      float: none !important;
      width: 100% !important;
      padding-right: 0 !important;
      margin-bottom: 20px;
    }
    .profile-bio {
      text-align: left !important;
      font-size: 13.5px !important;
    }
    .profile-name {
      font-size: 14px !important;
    }
    .profile-name strong {
      font-size: 15px !important;
    }
  }
  </style>

  <div class="profile-wrap">

    <!-- FLOATED LEFT IMAGE (45%) -->
    <div class="profile-float-img">
      <img src="/wp-content/uploads/2026/06/cv.jpg"
           alt="Prof. Raj Kumar Mittal">
    </div>

    <!-- NAME + BIO: sits right of image, wraps FULL WIDTH below image -->
    <div class="profile-name">
      <strong>आचार्य राज कुमार मित्तल</strong>
      कुलपति<br>
      बाबासाहेब भीमराव अम्बेडकर विश्वविद्यालय, लखनऊ<br>
      एवं<br>
      सदस्य, विश्वविद्यालय अनुदान आयोग, नई दिल्ली
    </div>

    <div class="profile-bio">
      <p>
आचार्य राज कुमार मिततल वर्तमान में बाबासाहेब भीमराव अम्बेडकर विश्वविद्यालय, लखनऊ के कुलपति तथा विश्वविद्यालय अनुदान आयोग के सदस्य हैं। प्रोफेसर मित्तल, एक उत्कृष्ठ संगठनकर्ता, कुशल प्रशासक, कर्तव्यष्ठि, सफल प्रबंधनकर्ता, सहज व्यक्तित्व के धनी होने के साथ ही ख्यातिलब्ध अर्थशास्त्री एवं शिक्षाविद् भी हैं। आपके पास उच्च शिक्षा के प्रतिष्ठित संस्थानों में शिक्षण, अनुसंधान और अकादमिक प्रशासन में लगभग 36 वर्षों का वृहद अनुभव है। आपने देश के सुप्रसिद्ध शिक्षण संस्थानो से पीएच.डी., एम.फिल., एम.ए. (अर्थशास्त्र), एम.बी.ए. तथा बी.काम. की शिक्षा प्राप्त की है। आपके कौशलपूर्ण शोध-निर्देशन में 20 से अधिक शोधार्थियों को पीएच.डी. की उपाधि प्रदान की गई है साथ ही 150 से अधिक एम.बी.ए. विद्यार्थियों को उनके लघु शोध परियोजनाओं के लिए मार्गदर्शन भी किया गया है। आप द्वारा 05 शोध परियोजनाओं का क्रियान्वयन, 06 पुस्तकों को प्रकाशन, 120 से अधिक संदर्भित अन्तर्राष्ट्रीय और राष्ट्रीय शोध-पत्रिकाओं में शोधपत्र प्रकाशित हैं।
</p>

      <p>प्रोफेसर मित्तल ने, चौधरी बंसीलाल विश्वविद्यालय, भिवानी, महर्षि वाल्मिकि संस्कृत विश्वविद्यालय, कैथल, हरियाणा (अतिरिक्त प्रभार) एवं तीर्थंकर महावीर विश्वविद्यालय, मुरादाबाद, उत्तर प्रदेश जैसे प्रतिष्ठित विश्वविद्यालयों के कुलपति के रूप में सफल कार्यकाल सपन्न किया है। वर्तमान में प्रोफेसर मित्तल, विकसित एवं आत्मनिर्भर भारत, स्वरोजगार एवं उद्यमिता, अर्थव्यवस्था में रोजगार सृजन, स्वदेशी, भारत का भारतीय मॉडल, जिम्मेदार उपभोग प्रवृत्ति को बढ़ावा देना, प्रबंधन में भारतीयता को बढ़ावा, राष्ट्रीय शिक्षा नीति-2020 का क्रियान्वयन तथा पंचकोश आधारित शिक्षा का विकास आदि विषयों में शोध, क्षमता विकास तथा युवाओं में जनजागरण को बढ़ावा दे रहे हैं। प्रोफेसर मित्तल को कई प्रतिष्ठित सम्मान एवं पुरूस्कारों से भी सम्मानित किया जा चुका है, जिसमें गुरू गोबिंद सिंह इंद्रप्रस्थ विश्वविद्यालय, दिल्ली द्वारा सर्वश्रेष्ठ शिक्षक पुरूस्कार, आई.ई.ई.ई.-यू.पी. चैप्टर द्वारा लाइफ टाइम अचीवमेंट अवार्ड तथा हरियाणा मैत्री संघ द्वारा उत्कृष्ठ उपलब्धि पुरूस्कार शामिल है।</p>
    </div>

  </div>

</div><!-- .container -->
</section>

<?php get_footer(); ?>