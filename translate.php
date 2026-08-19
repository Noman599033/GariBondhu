<?php
function update_lang_file($filepath, $new_keys) {
    $content = file_get_contents($filepath);
    
    // Find the end of the window.translations.en/bn object
    $pos = strrpos($content, '}');
    if ($pos === false) return;
    
    // Check if the previous character before } is a comma
    $before = trim(substr($content, 0, $pos));
    $needs_comma = substr($before, -1) !== ',';
    
    $additions = "";
    if ($needs_comma) $additions .= ",\n";
    
    foreach ($new_keys as $k => $v) {
        $additions .= '    "' . $k . '": "' . addslashes($v) . '",' . "\n";
    }
    
    // Remove last comma
    $additions = rtrim($additions, ",\n") . "\n";
    
    $new_content = substr($content, 0, $pos) . $additions . substr($content, $pos);
    
    file_put_contents($filepath, $new_content);
}

$en_keys = [
    "hero_title" => "Find Your Perfect Car",
    "hero_subtitle_accent" => "Anytime, Anywhere.",
    "hero_desc" => "Wide range of cars. Best prices. Easy booking. Your journey starts here.",
    "feat_1_title" => "1000+ Cars",
    "feat_1_desc" => "Wide Range of Vehicles",
    "feat_2_title" => "Best Price",
    "feat_2_desc" => "Affordable & Transparent",
    "feat_3_title" => "Easy Booking",
    "feat_3_desc" => "Quick & Simple Process",
    "feat_4_title" => "24/7 Support",
    "feat_4_desc" => "We are Always Here",
    "browse_type_title" => "Browse by Type",
    "browse_type_link" => "View All Cars",
    "type_suv" => "SUV",
    "type_sedan" => "Sedan",
    "type_hatchback" => "Hatchback",
    "type_luxury" => "Luxury",
    "type_convertible" => "Convertible",
    "offer_badge" => "Special Offer",
    "offer_title" => "Get 20% OFF",
    "offer_desc" => "On Your First Booking",
    "offer_btn" => "Book Now",
    "why_title" => "Why Choose Gari Bondhu?",
    "why_1_title" => "No Hidden Charges",
    "why_1_desc" => "What you see is what you pay.",
    "why_2_title" => "Free Cancellation",
    "why_2_desc" => "Up to 24 hours before pick-up.",
    "why_3_title" => "Clean & Safe Cars",
    "why_3_desc" => "Sanitized for your safety.",
    "why_4_title" => "Trusted by 10K+",
    "why_4_desc" => "Happy customers worldwide.",
    "reviews_title" => "Real Customer Reviews",
    "review_1" => "Excellent service! The car was clean and in perfect condition. Highly recommended for trips out of Dhaka.",
    "review_2" => "Easy booking process and friendly support team. Made my family trip very smooth.",
    "review_3" => "Best car rental service I've used so far. The prices are very competitive and transparent.",
    "pop_cars_title" => "Popular Cars for You",
    "pop_cars_desc" => "Handpicked cars for your next adventure.",
    "app_title" => "Download Gari Bondhu App<br>For Exclusive Deals",
    "app_desc" => "Get the best car rental experience right from your phone. Download our app and get an extra 20% off your first booking."
];

$bn_keys = [
    "hero_title" => "আপনার নিখুঁত গাড়ি খুঁজুন",
    "hero_subtitle_accent" => "যে কোনো সময়, যে কোনো জায়গায়।",
    "hero_desc" => "বিশাল গাড়ির কালেকশন। সেরা দাম। সহজ বুকিং। আপনার যাত্রা শুরু হোক এখান থেকে।",
    "feat_1_title" => "১০০০+ গাড়ি",
    "feat_1_desc" => "বিশাল কালেকশন",
    "feat_2_title" => "সেরা দাম",
    "feat_2_desc" => "সাশ্রয়ী ও স্বচ্ছ",
    "feat_3_title" => "সহজ বুকিং",
    "feat_3_desc" => "দ্রুত ও সহজ প্রক্রিয়া",
    "feat_4_title" => "২৪/৭ সাপোর্ট",
    "feat_4_desc" => "আমরা সবসময় আছি",
    "browse_type_title" => "ধরন অনুযায়ী খুঁজুন",
    "browse_type_link" => "সব গাড়ি দেখুন",
    "type_suv" => "এসইউভি",
    "type_sedan" => "সেডান",
    "type_hatchback" => "হ্যাচব্যাক",
    "type_luxury" => "লাক্সারি",
    "type_convertible" => "কনভার্টিবল",
    "offer_badge" => "বিশেষ অফার",
    "offer_title": "২০% ছাড় পান",
    "offer_desc": "আপনার প্রথম বুকিং এ",
    "offer_btn": "এখনই বুক করুন",
    "why_title": "কেন গাড়ি বন্ধু বেছে নিবেন?",
    "why_1_title": "কোন লুকানো চার্জ নেই",
    "why_1_desc": "যা দেখবেন, তাই পেমেন্ট করবেন।",
    "why_2_title": "ফ্রি ক্যান্সেলেশন",
    "why_2_desc": "পিক-আপের ২৪ ঘণ্টা আগে পর্যন্ত।",
    "why_3_title": "পরিষ্কার ও নিরাপদ গাড়ি",
    "why_3_desc": "আপনার সুরক্ষার জন্য জীবাণুমুক্ত।",
    "why_4_title": "১০,০০০+ বিশ্বস্ত গ্রাহক",
    "why_4_desc": "বিশ্বজুড়ে সুখী গ্রাহক।",
    "reviews_title": "গ্রাহকদের মতামত",
    "review_1": "চমৎকার সার্ভিস! গাড়িটি পরিষ্কার এবং নিখুঁত অবস্থায় ছিল। ঢাকার বাইরে ভ্রমণের জন্য দারুণভাবে সুপারিশ করছি।",
    "review_2": "সহজ বুকিং প্রক্রিয়া এবং বন্ধুত্বপূর্ণ সাপোর্ট টিম। আমার ফ্যামিলি ট্রিপ অনেক সহজ করে দিয়েছে।",
    "review_3": "আমার ব্যবহার করা সেরা কার রেন্টাল সার্ভিস। দামগুলো খুব সাশ্রয়ী এবং স্বচ্ছ।",
    "pop_cars_title": "আপনার জন্য জনপ্রিয় গাড়ি",
    "pop_cars_desc": "আপনার পরবর্তী অ্যাডভেঞ্চারের জন্য বাছাইকৃত গাড়ি।",
    "app_title": "বিশেষ অফার পেতে<br>গাড়ি বন্ধু অ্যাপ ডাউনলোড করুন",
    "app_desc": "আপনার ফোন থেকেই সেরা কার রেন্টাল অভিজ্ঞতা নিন। আমাদের অ্যাপ ডাউনলোড করুন এবং প্রথম বুকিং এ ২০% ছাড় পান।"
];

update_lang_file('public/lang/en.js', $en_keys);
update_lang_file('public/lang/bn.js', $bn_keys);
echo "Done";
