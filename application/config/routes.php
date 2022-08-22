<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//user routes
// $route['users/test-code'] = 'test/return_test_phpfile';
// $route['users/paynow'] = 'test/strip_pay';
// $route['localhost-email'] = 'test/send_test_email_from_localhost';
$route['users/logout'] = 'users/logout';
$route['users/check-email'] = 'users/check_email';
$route['users/email-exist'] = 'users/email_exist';
$route['users/register'] = 'users/register';
$route['users/renew-membership/(:num)'] = 'memberships/renew_membership/$1';
$route['membership/apply-coupon-code'] = 'memberships/apply_coupon_code';
$route['users/thankyou'] = 'users/thankyou';
$route['users/set-password/(:any)'] = 'users/set_password/$1';
$route['users/reset-password'] = 'users/forget_password_mail';
$route['users/reset-password/(:any)'] = 'users/reset_password/$1';
$route['users/feedback'] = 'users/feedback';
$route['users/terms-of-use'] = 'users/termsOfUse';

// payment
// $route['users/make-payment'] = 'payment/index';
// $route['payment/transaction'] = 'payment/payment_transaction';
// member dashboard
$route['users/dashboard'] = 'users/dashboard';
$route['users/eligibility'] = 'users/eligibility';
$route['users/profile'] = 'users/member_profile';
$route['users/profile/personal-info/(:any)'] = 'users/update_member_personal_info/$1';
$route['users/profile/work-info/(:any)'] = 'users/update_member_work_detail/$1';
// member gears
$route['users/gears'] = 'gears/membership_gears';
$route['users/add-proof/(:num)'] = 'gears/add_proof/$1';
$route['users/remove-proof/(:num)'] = 'gears/remove_proof/$1';
$route['users/add-gears'] = 'gears/add_membership_gears';
$route['users/gears/(:num)'] = 'gears/remove_gear/$1';

// member membership
$route['users/membership'] = 'memberships/membership';
$route['users/cancel-membership'] = 'memberships/cancel_membership';
$route['users/cancel-confirm'] = 'memberships/cancel_confirm_membership';
$route['users/offers'] = 'memberships/membership_offers';
$route['users/transaction'] = 'memberships/membership_transaction';

// member benefits
$route['users/sensor-clean'] = 'users/sensor_clean_vouchers';
$route['users/enquiry'] = 'users/general_enquiry';
$route['users/repair'] = 'users/book_a_repair';
$route['users/loan'] = 'users/trial_loan';
$route['users/loan-voucher'] = 'users/trial_loan_vouchers';
$route['users/get-serial-number'] = 'users/get_lumix_serial_number';
$route['users/password-protected/(:any)'] = 'users/voucher_password/$1';
$route['users/submit-voucher/(:any)'] = 'users/submit_member_voucher/$1';

$route['default_controller'] = 'pages/view';

//admin routs
$route['administrator/logout'] = 'administrator/logout';
$route['administrator'] = 'administrator/view';
$route['administrator/home'] = 'administrator/home';
$route['administrator/index'] = 'administrator/view';
$route['administrator/dashboard'] = 'administrator/dashboard';
$route['administrator/forget-password'] = 'administrator/forget_password';
$route['administrator/change-password'] = 'administrator/get_admin_data';
$route['administrator/update-profile'] = 'administrator/update_admin_profile';

$route['administrator/users/add-user'] = 'administrator/add_user';
$route['administrator/users'] = 'administrator/users';
$route['administrator/users/update-user/(:num)'] = 'administrator/update_user/$1';

// Store routes for administrater
$route['administrator/stores'] = 'stores/get_stores';
$route['administrator/add-store'] = 'stores/add_store';
$route['administrator/edit-store/(:num)'] = 'stores/edit_store/$1';
$route['administrator/store-action/(:num)'] = 'stores/activate_deactivate_store/$1';
$route['administrator/delete-store/(:num)'] = 'stores/delete_store/$1';

// Product routes for administrater
$route['administrator/products'] = 'products/get_products';
$route['administrator/add-product'] = 'products/add_product';
$route['administrator/edit-product/(:num)'] = 'products/edit_product/$1';
$route['administrator/product-action/(:num)'] = 'products/activate_deactivate_product/$1';
$route['administrator/delete-product/(:num)'] = 'products/delete_product/$1';
$route['administrator/eligibility-criteria'] = 'products/eligibility_criteria';
$route['administrator/criteria-update'] = 'products/criteria_update';
$route['administrator/product/position-update'] = 'products/position_update';

// member routes for administrater
$route['administrator/members/add-member'] = 'members/add_member';
$route['administrator/members'] = 'members/get_members';
$route['administrator/member/(:num)'] = 'members/member_detail/$1';
$route['administrator/add-promotion'] = 'members/send_promotion_and_coupon';
$route['administrator/promotion'] = 'members/members_promotion';
$route['administrator/promotion/(:any)'] = 'members/promotion_detail/$1';
$route['administrator/promotion/unpublish/(:any)'] = 'members/members_promotion_unpublish/$1';
$route['administrator/promotion/edit/(:any)'] = 'members/members_promotion_edit/$1';
// $route['administrator/members/export/(:num)'] = 'members/exportCSV/$1';
$route['send-contacts'] = 'members/send_contact_form_data_to_salesforce';

$route['administrator/blogs/add-blog'] = 'administrator/add_blog';
$route['administrator/blogs/list-blog'] = 'administrator/list_blog';
$route['administrator/blogs/update-blog'] = 'administrator/update_blog';

$route['administrator/product-categories/create'] = 'administrator/create_product_category';
$route['administrator/product-categories/update/(:any)'] = 'administrator/update_product_category/$1';
$route['administrator/product-categories'] = 'administrator/product_categories';
//$route['administrator/product-categories/(:any)'] = 'administrator/update_product_category/$1';

$route['administrator/faq-categories/create'] = 'administrator/create_faq_category';
$route['administrator/faq-categories/update/(:any)'] = 'administrator/update_faq_category/$1';
$route['administrator/faq-categories'] = 'administrator/faq_categories';

$route['administrator/faq/create'] = 'administrator/create_faq';
$route['administrator/faqs'] = 'administrator/get_faqs';
$route['administrator/faqs/update/(:any)'] = 'administrator/update_faqs/$1';

$route['administrator/scopages'] = 'administrator/get_scopages';
$route['administrator/sco-pages/update/(:any)'] = 'administrator/update_scopages/$1';

$route['administrator/sociallinks'] = 'administrator/get_sociallinks';
$route['administrator/sociallinks/update/(:any)'] = 'administrator/update_sociallinks/$1';

$route['administrator/sliders/create'] = 'administrator/create_slider';
$route['administrator/sliders'] = 'administrator/get_sliders';
$route['administrator/sliders/update/(:any)'] = 'administrator/update_slider/$1';

$route['administrator/site-configuration'] = 'administrator/get_siteconfiguration';
$route['administrator/site-configuration/update/(:any)'] = 'administrator/update_siteconfiguration/$1';

$route['administrator/page-contents'] = 'administrator/get_pagecontents';
$route['administrator/page-contents/update/(:any)'] = 'administrator/update_pagecontents/$1';

$route['administrator/galleries/add'] = 'galleries/galleriesLoad';
$route['administrator/galleries'] = 'galleries/get_gallery_images';

$route['administrator/blogs/blog-comments'] = 'administrator/list_blog_comments';
$route['administrator/blogs/view-comment/(:any)'] = 'administrator/view_blog_comments/$1';

$route['administrator/team/add'] = 'administrator/add_team';
$route['administrator/team/list'] = 'administrator/list_team';
$route['administrator/team/update/(:any)'] = 'administrator/update_team/(:any)';

$route['administrator/testimonials/add'] = 'administrator/add_testimonial';
$route['administrator/testimonials/list'] = 'administrator/list_testimonial';
$route['administrator/testimonials/update/(:any)'] = 'administrator/update_testimonial/(:any)';

$route['(:any)'] = 'pages/view/$1';
$route['eligibility/get-eligibility-requirements'] = 'pages/get_eligibility_requirements';
$route['404_override'] = 'pana404';
$route['translate_uri_dashes'] = FALSE;
