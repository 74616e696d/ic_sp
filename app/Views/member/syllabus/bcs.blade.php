@extends('master.layout')

@section('content')
<!-- <div class="bx">
	<div class="bx bx-header">
		<h3 class="bx-title">Syllabus</h3>
	</div>
	<div class="bx bx-body">
	</div>
</div> -->
<div class="col-lg-3 col-md-3 col-xs-12 col-sm-12 col-tabs"> <!-- required for floating -->
  <!-- Nav tabs -->
  <ul class="nav nav-tabs tabs-left"><!-- 'tabs-right' for right tabs -->
    <li class="active"><a href="#home" data-toggle="tab">কিভাবে আবেদন করবেন <i class="fa fa-chevron-right pull-right"></i></a></li>
    <li><a href="#profile" data-toggle="tab">সিলেবাস  <i class="fa fa-chevron-right pull-right"></i></a></li>
    <li><a href="#messages" data-toggle="tab">কিভাবে প্রস্তুতি নিবেন <i class="fa fa-chevron-right pull-right"></i></a></li>
  </ul>
</div>
<div class="col-lg-9 col-md-9 col-xs-12 col-sm-12 col-tab-content">
    <!-- Tab panes -->
    <div class="tab-content">
     <div class="tab-pane active" id="home">
      <h4 style='margin-top:1px'>কিভাবে আবেদন করবেন</h4>
      <ul class="list-unstyled list-main">
      	<li><p>১।</p>
	      	<ul class="list-unstyled list-inner">
	      		<li>
	      			ক. নতুন পদসৃষ্টি, পদোন্নতি, কর্মকর্তার অবসর গ্রহণ, মৃত্যু, পদত্যাগ অথবা অপসারণ ইত্যাদি কারণে
	      			উপরোল্লিখিত যে কোনো ক্যাডারের পদের সংখ্যা বাড়ানো হতে পারে। অলঙ্ঘনীয় প্রশাসনিক বা আইনি
	      			বাধ্যবাধকতার কারণে শূন্য পদসংখ্যার পরিবর্তন হতে পারে।
	      		</li>
	      		<li>
	      			খ. কোনো প্রার্থীর বিজ্ঞাপনে উল্লিখিত ক্যাডার পদের জন্য নির্ধারিত শিক্ষাগত যোগ্যতা না থাকলে উক্ত প্রার্থী
	      			পরীক্ষায় অংশগ্রহণ করতে পারবেন না। কোনো প্রার্থী বিদেশ হতে তাঁর অর্জিত কোনো ডিগ্রিকে
	      			উপরোল্লিখিত বিসিএস ক্যাডারের পদসমূহের পার্শ্বে বর্ণিত কোনো শিক্ষাগত যোগ্যতার সমমানের বলে
	      			দাবি করলে তাকে সে মর্মে সংশ্লিষ্ট ইকুইভ্যালেন্স কমিটি কর্তৃক প্রদত্ত ইকুইভ্যালেন্স সনদের সত্যায়িত কপি
	      			লিখিত পরীক্ষার পূর্বে বিপিএসসি ফরম-২ এর সঙ্গে জমা দিতে হবে। ইকুইভ্যালেন্স সনদের জন্য প্রকৌশল
	      			বিষয়ের ডিগ্রিধারীদেরকে বাংলাদেশ প্রকৌশল বিশ্ববিদ্যালয়ের (বুয়েট) সঙ্গে, মেডিকেল ডিগ্রিধারীদেরকে
	      			বিএমডিসি’র সঙ্গে এবং সাধারণ বিষয়ে ডিগ্রিধারীদেরকে শিক্ষা মন্ত্রণালয়ের সঙ্গে যোগাযোগ করতে
	      			পরামর্শ দেয়া যাচ্ছে। উক্ত ইকুইভ্যালেন্স সনদের মূলকপি মৌখিক পরীক্ষার সময় সাক্ষাৎকার বোর্ডে
	      			অবশ্যই উপস্থাপন করতে হবে।
	      		</li>
	      		<li>
	      			গ. যদি কোনো প্রার্থী এমন কোনো পরীক্ষায় অবতীর্ণ হয়ে থাকেন যে পরীক্ষায় চাহিদাকৃত শ্রেণি/বিভাগসহ পাস করলে
	      			তিনি ৩৬তম বিসিএস পরীক্ষা দেয়ার যোগ্যতা অর্জন করবেন এবং যদি তার ঐ পরীক্ষার ফলাফল ৩৬তম বিসিএসএর
	      			আবেদনপত্র দাখিলের শেষ তারিখ পর্যন্ত প্রকাশিত না হয় তাহলে তিনি অনলাইনে আবেদনপত্র দাখিল করতে
	      			পারবেন, তবে তা সাময়িকভাবে গ্রহণ করা হবে। কেবল সেই প্রার্থীকেই অবতীর্ণ প্রার্থী হিসেবে বিবেচনা করা হবে
	      			যার স্নাতক বা স্নাতকোত্তর পর্যায়ের সকল লিখিত পরীক্ষা ৩৬তম বিসিএস পরীক্ষার আবেদনপত্র গ্রহণের শেষ
	      			তারিখের মধ্যে অর্থাৎ ২৩.০৭.২০১৫ তারিখের মধ্যে সম্পূর্ণরূপে শেষ হয়েছে। এ মর্মে সংশ্লিষ্ট পরীক্ষা নিয়ন্ত্রক,
	      			বিশ্ববিদ্যালয়ের বিভাগীয় চেয়ারম্যান বা শিক্ষা প্রতিষ্ঠানের প্রধান কর্তৃক প্রদত্ত প্রত্যয়নপত্রের সত্যায়িত কপি প্রার্থী
	      			লিখিত পরীক্ষার পূর্বে বিপিএসসি ফরম-২ এর সঙ্গে দাখিল করবেন। স্নাতক/স্নাতকোত্তর পরীক্ষা শুরু ও শেষ
	      			হওয়ার তারিখ উল্লেখবিহীন কোনো অবতীর্ণ প্রত্যয়নপত্র গ্রহণযোগ্য হবে না। বিসিএস-এর মৌখিক পরীক্ষার সময়
	      			উক্ত পরীক্ষা পাসের প্রমাণস্বরূপ বিশ্ববিদ্যালয়ের মূল/সাময়িক সার্টিফিকেট এবং অবতীর্ণ হওয়ার প্রত্যয়নপত্রের মূল
	      			কপি কমিশনে অবশ্যই দাখিল করতে হবে। অন্যথায় মৌখিক পরীক্ষা গ্রহণ করা হবে না এবং প্রার্থিতাও বাতিল বলে
	      			গণ্য হবে।
	      		</li>
	      		<li></li>
	      		<li></li>
	      		<li></li>
	      	</ul>
      	</li>
      	<li>
      		<p>২। অনলাইনে আবেদনপত্র (BPSC Form-1) পূরণ এবং পরীক্ষার ফি জমাদান শুরু ও শেষ
হওয়ার তারিখ ও সময় :</p>
      		<ul class="list-unstyled list-inner">
      			<li>
      				ক. আবেদনপত্র পূরণ ও ফি জমাদান শুরুর তারিখ ও সময় : ১৪.০৬.২০১৫ তারিখ সকাল-১০:০০ টা।
      			</li>
      			<li>
      				খ. আবেদনপত্র জমাদানের শেষ তারিখ ও সময় : ২৩.০৭.২০১৫ তারিখ সন্ধ্যা ৬:০০ টা।
      			</li>
      			<li>
      				গ. আবেদনপত্র গ্রহণের শেষ তারিখ : ২৩.০৭.২০১৫ সন্ধ্যা ৬:০০ টার মধ্যে। শুধুমাত্র User ID প্রাপ্ত
      				প্রার্থীগণ উক্ত সময়ের পরবর্তী ৭২ ঘণ্টা (অর্থাৎ ২৬.০৭.২০১৫ সন্ধ্যা ৬:০০ টা পর্যন্ত) SMSএর মাধ্যমে
      				(বিজ্ঞাপনের ৯নং অনুচ্ছেদের নির্দেশনা অনুসরণ করে) ফি জমা দিতে পারবেন। নির্ধারিত তারিখ ও
      				সময়ের পর কোনো আবেদনপত্র গ্রহণ করা হবে না।
      				বি.দ্র. : Applicant’s Copy-তে উল্লিখিত সময় অনুযায়ী (অর্থাৎ ৭২ ঘণ্টা) প্রার্থীদের ফি জমাদান
      				সম্পন্ন করতে পরামর্শ দেওয়া হলো। কাজেই শেষ তারিখ ও সময়ের জন্য অপেক্ষা না করে হাতে যথেষ্ট
      				সময় নিয়ে আবেদনপত্র জমাদান চূড়ান্ত করতে পরামর্শ দেয়া যাচ্ছে।
      			</li>
      		</ul>
      	</li>

      	<li>
      		<p>৩। বয়সসীমা : ০১ মে, ২০১৫ খ্রিঃ তারিখে বয়স :</p>
      		<ul class='list-unstyled list-inner'>
      			<li>ক. মুক্তিযোদ্ধা, মুক্তিযোদ্ধা/শহীদ মুক্তিযোদ্ধাদের পুত্র-কন্যা, প্রতিবন্ধী প্রার্থী এবং বিসিএস (স্বাস্থ্য) ক্যাডারের প্রার্থী
ছাড়া অন্যান্য সকল ক্যাডারের প্রার্থীর জন্য বয়স ২১ হতে ৩০ বছর (জন্মতারিখ সর্বনিম্ন ০২-০৫-১৯৯৪
সর্বোচ্চ ০২-০৫-১৯৮৫ পর্যন্ত)।</li>
      			<li>খ. মুক্তিযোদ্ধা, মুক্তিযোদ্ধা/শহীদ মুক্তিযোদ্ধাদের পুত্র-কন্যা, প্রতিবন্ধী প্রার্থী এবং বিসিএস(স্বাস্থ্য) ক্যাডারের প্রার্থীর
জন্য বয়স ২১ হতে ৩২ বছর (জন্মতারিখ সর্বনিম্ন ০২-০৫-১৯৯৪ সর্বোচ্চ ০২-০৫-১৯৮৩ পর্যন্ত)।</li>
      			<li>গ. বিসিএস (সাধারণ শিক্ষা) ক্যাডারের জন্য শুধুক্ষুদ্র নৃ-গোষ্ঠী প্রার্থীর বেলায় বয়স ২১ হতে ৩২ বছর (জন্মতারিখ
সর্বনিম্ন ০২-০৫-১৯৯৪ সর্বোচ্চ ০২-০৫-১৯৮৩ পর্যন্ত)।
প্রার্থীর বয়স কম বা বেশি হলে আবেদনপত্র গ্রহণযোগ্য হবে না।</li>
      		</ul>
      	</li>

      	<li>
      		<p>৪। জাতীয়তা :</p>
      		<ul class="list-unstyled list-inner">
      			<li>ক. প্রার্থীকে অবশ্যই বাংলাদেশের নাগরিক হতে হবে।</li>
      			<li>খ. সরকারের পূর্বানুমতি ব্যতিরেকে কোনো প্রার্থী কোনো বিদেশী নাগরিককে বিবাহ করে থাকলে বা বিবাহ
করতে প্রতিজ্ঞাবদ্ধ হয়ে থাকলে তিনি পরীক্ষায় অংশগ্রহণের অযোগ্য বলে বিবেচিত হবেন। সরকারের
অনুমতিপত্র বিপিএসসি ফরম-২ এর সঙ্গে অবশ্যই জমা দিতে হবে।</li>
      		</ul>
      	</li>

      	<li>
      		<p>৫। </p>
      		<ul class="list-unstyled list-inner">
      			<li>ক. লিঙ্গ নির্বিশেষে বাংলাদেশের যে কোনো ব্যক্তি সার্ভিসের পরীক্ষায় অংশগ্রহণের জন্য যোগ্য বলে গণ্য
হবেন।</li>
      			<li>খ. প্রজাতন্ত্রের কর্মে অথবা স্থানীয় কর্তৃপক্ষের অধীন চাকুরিরত প্রার্থীগণের মধ্যে যাদের পরীক্ষায় অংশগ্রহণের
যোগ্যতা রয়েছে তারা নিয়োগকারী কর্তৃপক্ষ কর্তৃক অনুমতিপ্রাপ্ত হলে পরীক্ষায় অংশগ্রহণ করতে পারবেন।</li>
      		</ul>
      	</li>

      	<li>
      		<p>৬। বিসিএস পরীক্ষার আবেদনপত্র :</p>
      		<ul class="list-unstyled list-inner">
      			<li>ক. বিসিএস পরীক্ষায় প্রাপ্ত আবেদনপত্র দ্রুত প্রক্রিয়ায়ণ শেষে স্বল্প সময়ের মধ্যে পরীক্ষা গ্রহণের লক্ষ্যে ৩৬তম
বিসিএস-এর প্রিলিমিনারি টেস্টে অংশগ্রহণকারী প্রার্থীদের এই বিজ্ঞাপনের ৭নং অনুচ্ছেদে উল্লিখিত পদ্ধতিতে
শুধুকমিশন কর্তৃক অনুমোদিত আবেদনপত্র (ইচঝঈ ঋড়ৎস-১) অনলাইনে পূরণ করে আবেদন করতে হবে।
প্রিলিমিনারি টেস্টে উত্তীর্ণ প্রার্থীগণ পরবর্তীতে কমিশনের <a href="http://www.bpsc.gov.bd/" target='_blank'>www.bpsc.gov.bd</a> ওয়েবসাইট থেকে মূল
আবেদনপত্র বিপিএসসি ফরম-২ Download করে ফরম-২-এ এবং বিজ্ঞাপনের ১৪নং অনুচ্ছেদে উল্লিখিত
কাগজপত্রসহ লিখিত পরীক্ষার পূর্বে কমিশন কর্তৃক নির্ধারিত সময়ে ও স্থানে জমা দিবেন।</li>
      			<li>খ. প্রিলিমিনারি টেস্টে কৃতকার্য প্রার্থীদের এই বিজ্ঞাপনের ১৪নং অনুচ্ছেদ অনুযায়ী বিপিএসসি ফরম-২ জমা দেয়ার
পর লিখিত পরীক্ষার পূর্বে কমিশন কর্তৃক নির্ধারিত সময়ে অনলাইনে Teletalk BD LTD-এর Web Address
<a href="http://bpsc.teletalk.com.bd/" target='_blank'>www.bpsc.teletalk.com.bd</a> অথবা বাংলাদেশ সরকারী কর্ম কমিশনের Web Address: <a href="http://www.bpsc.gov.bd/" target='_blank'>www.bpsc.gov.bd</a>-এর মাধ্যমে অতিরিক্ত তথ্য সংবলিত একটি সংক্ষিপ্ত অনলাইন ফরম (বিপিএসসি ফরম-৩) কমিশন কর্তৃক নির্ধারিত সময়ের মধ্যে অবশ্যই পূরণ করতে হবে। এ বিষয়ে কমিশন কর্তৃক প্রেসবিজ্ঞপ্তি মারফত এবং ইচঝঈ ঋড়ৎস-১-এ উল্লিখিত প্রার্থীর মোবাইল নম্বরে Teletalk হতে
SMS-এর মাধ্যমে প্রার্থীদের বিস্তারিত নির্দেশনা প্রদান করা হবে। কমিশনের নির্দেশনা অনুযায়ী অনলাইনে
পূরণকৃত উক্ত সংক্ষিপ্ত ফরম (বিপিএসসি ফরম-৩) Downloadকরে এক কপি প্রার্থী নিজের কাছে সংরক্ষণ
করবেন। মৌখিক পরীক্ষার বোর্ডে প্রার্থীকে পূরণকৃত উক্ত ফরম-৩ দাখিল করতে হবে।</li>
      		</ul>
      	</li>

      	<li>
      		<p>৭। অনলাইনে BPSC FORM-1 পূরণ :</p>
      		প্রার্থীকে Teletalk BD LTD-এর Web Address
      		www.bpsc.teletalk.com.bd অথবা বাংলাদেশ সরকারী কর্ম কমিশনের Web Address: <a href='http://www.bpsc.gov.bd/' target='_blank'>www.bpsc.gov.bd</a>-এর মাধ্যমে কমিশন কর্তৃক নির্ধারিত আবেদনপত্র BPSC Form-1 পূরণ করে Online Registration কার্যক্রম এবং ফি জমাদান সম্পন্ন
      		করতে হবে। উল্লিখিত ওয়েবসাইট ওপেন করলে ৩৬তম বিসিএস-এর Advertisement, অনলাইনে
      		আবেদনপত্র পূরণের বিস্তারিত নির্দেশাবলি এবং Cadre Option-এর ভিত্তিতে ক্সতরিকৃত ৩ ক্যাটাগরি পদের
      		জন্য নির্ধারিত Application Form (BPSC Form-1)-এর রেডিও বাটন দৃশ্যমান হবে।

      		Advertisement-এর রেডিও বাটন ক্লিক করলে ৩৬তম বিসিএস এর বিজ্ঞাপন পাওয়া যাবে। কমিশনের
      		<a href="http://www.bpsc.gov.bd/" target='_blank'>http://www.bpsc.gov.bd/</a> ওয়েবসাইটে আবেদনপত্র পূরণের বিষয়ে ১৫ পৃষ্ঠা সংবলিত বিস্তারিত নির্দেশনা দেয়া
      		আছে। অনলাইন ফরম পূরণের পূর্বে প্রার্থী উক্ত নির্দেশনা অংশটি Download করে প্রতিটি নির্দেশনা ভালভাবে
      		আয়ত্ত করে নিতে পারবেন। ক্যাডার চয়েস-এর উপর ভিত্তি করে Application Form-এর ৩টি ক্যাটাগরি
      		রয়েছে, যেমন- – (1) Application Form for General Cadre, (2) Application Form for Technical Cadre/Professional Cadre (3) Application Form for General and Technical/ Professional (Both) Cadre। প্রার্থী শুধু জেনারেল ক্যাডারের জন্য প্রার্থী হতে ইচ্ছুক হলে জেনারেল ক্যাডারের Application Form-এর রেডিও বাটন ক্লিক করলে General Cadre- এর আবেদনপত্র
      		((BPSC Form-1) দৃশ্যমান হবে। অনুরূপভাবে General and Technical/Professional ক্যাডারের প্রার্থী
      		হতে ইচ্ছুক হলে তাকে Both Cadre-এর জন্য নির্ধারিত ৩য় রেডিও বাটনটি ক্লিক করলে নির্ধারিত Both Cadre–এর জন্য BPSC Form-1 দৃশ্যমান হবে। BPSC Form-1 দৃশ্যমান হলে ফর্মের প্রতিটি অংশ প্রদত্ত Instructionঅনুযায়ী পূরণ করতে হবে। BPSC Form-1 এর ৩টি অংশ রয়েছে : Part-1 Personal Information, Part-2 Educational Qualification, Part-3 Cadre Option. Instructions for Submitting Application অংশের বিস্তারিত নির্দেশনা এবং BPSC Form-1-এর প্রতিটি Field-এ প্রদত্ত তথ্য/নির্দেশনা অনুসরণ করে BPSC Form-1 পূরণ করতে হবে।
      	</li>

      	<li>
      		<p>৮। ডিক্লারেশন :</p>
      		প্রার্থীকে অনলাইন আবেদনপত্রের (BPSC Form-1) ডিক্লারেশন অংশে এই মর্মে ঘোষণা দিতে হবে যে, প্রার্থী
      		কর্তৃক আবেদনপত্রে প্রদত্ত সকল তথ্য সঠিক এবং সত্য। প্রদত্ত তথ্য অসত্য বা মিথ্যা প্রমাণিত হলে অথবা কোনো
      		অযোগ্যতা ধরা পড়লে বা কোনো প্রতারণা বা দুর্নীতির আশ্রয় গ্রহণ করলে পরীক্ষার পূর্বে বা পরে এমনকি নিয়োগের
      		পরে যে কোনো পর্যায়ে প্রার্থিতা বাতিল এবং কমিশন কর্তৃক গৃহীতব্য যে কোনো নিয়োগ পরীক্ষায় আবেদন করার
      		অযোগ্য ঘোষণাসহ তার বিরুদ্ধে যে কোনো আইনগত ব্যবস্থা গ্রহণ করা যাবে। প্রার্থী কর্তৃক BPSC Form-1-এ
      		প্রদত্ত ডিক্লারেশন অনুযায়ী প্রিলিমিনারি টেস্টের জন্য ওয়েবসাইট থেকে স্বয়ংক্রিয়ভাবে উড়হিষড়ধফ করে
      		সাময়িকভাবে প্রবেশপত্র গ্রহণ করবেন। পরবর্তীতে উপরোল্লিখিত কোনোরূপ অযোগ্যতা প্রমাণিত হলে সাময়িকভাবে
      		প্রাপ্ত প্রবেশপত্র ও প্রার্থিতা বাতিল বলে গণ্য হবে। প্রিলিমিনারি টেস্টে কৃতকার্য হলে প্রার্থী কর্তৃক অনলাইন
      		আবেদনপত্রে (BPSC Form-1) প্রদত্ত প্রতিটি তথ্যের সপক্ষে যথাযথ সনদ/প্রত্যয়নপত্র লিখিত পরীক্ষার পূর্বে
      		বিপিএসসি ফরম-২ এবং এই বিজ্ঞাপনের ১৪নং অনুচ্ছেদের নির্দেশনা অনুসারে সংশ্লিষ্ট কাগজপত্র কমিশনে জমা
      		দিতে হবে। কোনো প্রার্থী অনলাইনে BPSC Form-1-এ প্রদত্ত তথ্য ও শিক্ষাগত যোগ্যতার প্রমাণস্বরূপ
      		বিপিএসসি ফরম-২ এর সঙ্গে যথাযথ সনদ/প্রত্যয়নপত্র দাখিল করতে ব্যর্থ হলে বা কোনো ক্যাডারের জন্য নির্ধারিত
      		যোগ্যতা না থাকলে বা আবেদন ভুলভাবে পূরণ করলে বা কোনো অযোগ্যতা বা কোনো Substantive ত্রুটি ধরা
      		পড়লে যে কোনো পর্যায়ে তার প্রার্থিতা বাতিল বলে গণ্য হবে।
      	</li>

      	<li><p>৯। পরীক্ষার ফি প্রদান :</p>
      		Online-এ আবেদনপত্র (BPSC Form-1) যথাযথভাবে পূরণপূর্বক নির্দেশনা মতে ছবি এবং Signature Upload করে প্রার্থী কর্তৃক আবেদনপত্র Submit সম্পন্ন হলে কম্পিউটারে ছবিসহ Application Preview কপি দেখা যাবে। নির্ভুলভাবে আবেদনপত্র Submit সম্পন্ন হলে প্রার্থী একটি USER ID সহ ছবি এবং স্বাক্ষরযুক্ত একটি Applicant’s Copy পাবেন। Preview এবং Applicant’s Copy-তে প্রার্থীর ছবি ও স্বাক্ষর অবশ্যই দৃশ্যমান হতে হবে। উক্ত Applicant’s Copy প্রার্থীকে Print অথবা Download
      		করে সংরক্ষণ করতে হবে। Applicant’s কপিতে একটি USER ID নম্বর দেয়া থাকবে এবং এই USER ID
      		নম্বর ব্যবহার করে Teletalk Bangladesh Ltd.কর্তৃক SMS এর মাধ্যমে প্রদত্ত নির্দেশনা অনুসারে প্রার্থী
      		নিম্নোক্ত পদ্ধতিতে যে কোনো Teletalk Pre-paid Mobile নম্বরের মাধ্যমে SMS করে ৩৬তম বিসিএস
      		পরীক্ষার ফি ৭০০ (সাতশত) টাকা এবং প্রতিবন্ধী এবং ক্ষুদ্র নৃ-গোষ্ঠীভুক্ত বা তৃতীয় লিঙ্গের প্রার্থী ১০০/-
      		(একশত টাকা) জমা দিবেন এবং Admit Card Download করে Print করতে পারবেন। বিশেষভাবে
      		উল্লেখ্য, প্রতিবন্ধী, ক্ষুদ্র নৃ-গোষ্ঠীভুক্ত বা তৃতীয় লিঙ্গভুক্ত প্রার্থী না হয়ে যে সকল সাধারণ প্রার্থী উক্ত অনগ্রসর
      		নাগরিক গোষ্ঠীর জন্য নির্ধারিত ১০০ টাকার ফি জমা দিয়ে আবেদনপত্র দাখিল করবেন নির্ধারিত ফি জমা না
      		দেয়ার কারণে সে সকল প্রার্থীর প্রার্থিতা বাতিল বলে গণ্য হবে।
      		প্রথম SMS: : BCS User ID লিখে send করুন ১৬২২২ নম্বরে।
      		Reply : Applicant’s Name, Tk-700(100 Tk. for Physically Handicapped, Ethnic Minority Group and Third Gender Group Candidates) will be Charged as Application Fee. Your PIN is (8 digit number) 12345678. To Pay Fee, type BCS < Space>Yes PIN and send to 16222.
      		দ্বিতীয় SMS: BCS Yes PIN লিখে Send করুন ১৬২২২ নম্বরে।
      		Reply : Congratulations! Applicant’s Name, payment completed successfully for 36 th BCS Examination. User ID is (xxxxxxxx) and Password (xxxxxxxx). N.B. : For Lost Password, Please Type BCSHELPSSC Board SSC RollSSC Year and send to 16222 |
      	</li>

      	<li>
      		<p>১০। ছবি (Photo) :</p>
      		BPSC Form-1 এর Part-1, Part-2 এবং Part-3 সাফল্যজনকভাবে পূরণ সম্পন্ন হলে Application Preview দেখা যাবে। Previewএর নির্ধারিত স্থানে প্রার্থীকে (দৈর্ঘ্য x প্রস্থ) ৩০০x ৩০০ Pixel এর কম বা বেশি নয় এবং File Size ১০০ KB এর বেশি গ্রহণযোগ্য নয়, এরূপ মাপের অনধিক তিন মাস পূর্বে তোলা নিজের রঙিন ছবি Scanকরে Upload করতে হবে। সাদাকালো ছবি
গ্রহণযোগ্য হবে না। Applicant’s Copy-তে ছবি মুদ্রিত না হলে আবেদনপত্র বাতিল হবে।
সানগ্লাসসহ ছবি গ্রহণযোগ্য হবে না। Home Page-এর Help Menu-তে ক্লিক করলে Photo এবং Signature সম্পর্কে বিস্তারিত নির্দেশনা পাওয়া যাবে।
      	</li>

      	<li>
      		<p>১১। স্বাক্ষর (Signature ) :</p>
      		Application Preview তে স্বাক্ষরের জন্য নির্ধারিত স্থানে (দৈর্ঘ্য x প্রস্থ) ৩০০ x ৮০ Pixel এর কম বা বেশি নয় এবং File Size ৬০ KB এর বেশি গ্রহণযোগ্য নয়, প্রার্থীকে এরূপ মাপের নিজের স্বাক্ষর Scanকরে Upload করতে হবে। Applicant’s Copy-তে স্বাক্ষর উল্লিখিত নির্দেশনা অনুযায়ী মুদ্রিত না হলে আবেদনপত্র বাতিল বলে গণ্য হবে।
      	</li>

      	<li>
      		<p>১২। প্রবেশপত্র ((Admit Card) :</p>
      		উপরের নির্দেশনা অনুসারে পরীক্ষার নির্ধারিত ফি জমা হলে টেলিটক হতে প্রেরিত উত্তরে প্রদত্ত একটি টংবৎ
      		ওউ এবং চধংংড়িৎফ ব্যবহার করে প্রার্থী তার প্রার্থিত কেন্দ্রের নিম্নোক্ত রেজিঃ নম্বরের রেঞ্জ হতে
      		কম্পিউটারের মাধ্যমে স্বয়ংক্রিয়ভাবে ওয়েবসাইট থেকে উড়হিষড়ধফ করে সাময়িকভাবে রেজিঃ নম্বর সংবলিত
      		অফসরঃ ঈধৎফ সংগ্রহ করতে পারবেন। পরবর্তীতে কোনোরূপ অযোগ্যতা ধরা পরলে পরীক্ষার পূর্বে বা পরে
      		যে কোনো পর্যায়ে প্রবেশপত্র বাতিল বলে গণ্য হবে।
      	</li>
      </ul>
      	
      </div> <!-- end apply instructions -->
      <div class="tab-pane" id="profile">
      	<ul class="list-unstyled list-main">
      		<li><p><strong>প্রিলিমিনারি টেস্টের</strong> বিষয় ও নম্বর বণ্টন প্রদান করা হলো :</p>
      		ক্রমিক নং বিষয়ের নাম নম্বর বণ্টন
      		<ul class="list-unstyled list-inner">
      			<li>১. বাংলা ভাষা ও সাহিত্য ৩৫</li>
      			<li>২. ইংরেজি ভাষা ও সাহিত্য ৩৫</li>
      			<li>৩. বাংলাদেশ বিষয়াবলি ৩০</li>
      			<li>৪. আন্তর্জাতিক বিষয়াবলি ২০</li>
      			<li>৫. ভূগোল (বাংলাদেশ ও বিশ্ব), পরিবেশ ও দুর্যোগ ব্যবস্থাপনা ১০</li>
      			<li>৬. সাধারণ বিজ্ঞান ১৫</li>
      			<li>৭. কম্পিউটার ও তথ্য প্রযুক্তি ১৫</li>
      			<li>৮. গাণিতিক যুক্তি ১৫</li>
      			<li>৯. মানসিক দক্ষতা ১৫</li>
      			<li>১০. নৈতিকতা, মূল্যবোধ ও সুশাসন ১০</li>
      			<li><strong>মোট ২০০</strong></li>
      		</ul>
      		</li>
      		<li><p><strong>লিখিত ও মৌখিক পরীক্ষার</strong> বিষয়সমূহ ও নম্বর বণ্টন : মোট নম্বর ১১০০ (মৌখিক পরীক্ষাসহ)</p>
      			<p><strong>১. সাধারণ ক্যাডারের জন্য :</strong></p>
      			<ul class="list-unstyled list-inner">
      				<li>ক. বাংলা ২০০</li>
      				<li>খ. ইংরেজি ২০০</li>
      				<li>গ. বাংলাদেশ বিষয়াবলি ২০০</li>
      				<li>ঘ. আন্তর্জাতিক বিষয়াবলি ১০০</li>
      				<li>ঙ. গাণিতিক যুক্তি ও মানসিক দক্ষতা (মানসিক দক্ষতা পরীক্ষার MCQ Type ৫০ টি প্রশ্ন থাকবে। প্রার্থী মানসিক দক্ষতা বিষয়ের প্রতিটি শুদ্ধ উত্তরের জন্য ১ (এক) নম্বর পাবেন। তবে প্রতিটি ভুল উত্তরের জন্য ০.৫০ নম্বর কাটা যাবে) ১০০</li>
      				<li>চ. সাধারণ বিজ্ঞান ও প্রযুক্তি ১০০</li>
      				<li>ছ. মৌখিক পরীক্ষা ২০০</li>
      				<li><strong>সর্বমোট = ১১০০</strong></li>
      			</ul>
      			<p><strong>২. প্রফেশনাল/টেকনিক্যাল ক্যাডারের জন্য :</strong></p>
      			বিষয় নম্বর বণ্টন
      			<ul class="list-unstyled list-inner">
      				<li>ক. বাংলা ১০০</li>
      				<li>খ. ইংরেজি ২০০</li>
      				<li>গ. বাংলাদেশ বিষয়াবলি ২০০</li>
      				<li>ঘ. আন্তর্জাতিক বিষয়াবলি ১০০</li>
      				<li>ঙ. গাণিতিক যুক্তি ও মানসিক দক্ষতা(মানসিক দক্ষতা পরীক্ষার MCQ Type ৫০ টি প্রশ্ন থাকবে। প্রার্থী মানসিক দক্ষতা বিষয়ের প্রতিটি শুদ্ধ উত্তরের জন্য ১ (এক) নম্বর
পাবেন। তবে প্রতিটি ভুল উত্তরের জন্য ০.৫০ নম্বর কাটা যাবে) ১০০</li>
      				<li>চ. সংশ্লিষ্ট পদ বা সার্ভিসের জন্য প্রাসঙ্গিক বিষয় ২০০</li>
      				<li>ছ. মৌখিক পরীক্ষা ২০০</li>
      				<li><strong>সর্বমোট = ১১০০</strong></li>
      			</ul>
      		</li>
      	</ul>
      </div>
      <div class="tab-pane" id="messages">
      	
      </div>
    </div>
</div>
@stop

@section('style')
<link rel="stylesheet" href="{{$base_url}}asset/member/css/bootstrap.vertical-tabs.min.css">
<style>
.nav-tabs>li>a:hover
{
	/*display: inline-block;*/
}
.nav-tabs>li.active,.nav-tabs>li.active>a
{
	background: #0177BF;
	color: #fff;
}
/*.nav-tabs>li.active>a
{
	color: color
}*/
.col-tabs
{
	padding-right: 0;
	padding-left: 0;
	/*min-height: 550px;*/
	background: #e2e2e2;
}
.tabs-left > li, .tabs-right > li
{
	margin-bottom: 0;
}
.col-tab-content
{
	padding-left: 0;
      padding-right: 0;
}
.tabs-left, .tabs-right
{
	padding-top: 0;
}
.tab-content
{
	min-height: 550px;
	background: #fff;
	padding-top: 10px;
	padding-left: 15px;
	padding-right: 15px;
	line-height:20px;
}
.tabs-left li
{
	border-bottom: 1px solid #f6f6f6;
}

.tabs-left > li > a
{
	font-size: 18px;
	text-align: center;
	border-radius: 0;
}

.tabs-left > li > a>i
{
	display: none;
	line-height: 1.5;
}

.list-main
{

}
.list-main>li
{
	padding-top:5px;
	padding-bottom: 5px;
}

.list-main>li>p
{
	font-size: 16px;
	background: #e2e2e2;
	padding:5px;
}

.list-inner li
{
	padding-bottom:7px;
	padding-left: 10px;
}
</style>
@stop

@section('script')
<script type="text/javascript">
$(document).ready(function() {
	// $('.nav-tabs>li').on('mouseover','a'function(event) {
		
	// });

$('.nav-tabs>li>a').hover(
	  function () {
	    $(this).children('i').show();
	  }, 
	  function () {
	    $(this).children('i').hide();
	  }
	);
});
(function ($) {
  $(function () {
    $(document).on('mouseenter.bs.tab.data-api', '[data-toggle="tab"], [data-hover="tab"]', function () {
      $(this).tab('show');
    });
  });
  // $(document).off('click.bs.tab.data-api', '[data-hover="tab"]');
})(jQuery);
</script>
@stop