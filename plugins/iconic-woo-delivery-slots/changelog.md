2024-11-19 - version 2.6.0  
[update] Performance improvements on the checkout page: Skip SQL queries when none of the time slots have a Max Order Limit  
[fix] Select the reserved slot on block checkout  
[fix] Bug where the date appear as one day short in the admin order table when timeslot is ASAP  
[fix] Bug where incorrect timeslot appear when address change trigger a shipping zone change too  

2024-09-24 - version 2.5.0  
[new] Make the delivery date column sortable in the admin orders screen for HPOS   
[fix] Bug where orders status would be changed to `on-hold` when order contains delivery slots  
[fix] Inconsistent date format showing in orders column  
[fix] Shipping method based holidays resulting in inconsistent dates output after AJAX  
[fix] Handle error caused by invalid holiday format  

2024-07-17 - version 2.4.0  
[update] Show popup for express payment automatically on the Order Received page  
[fix] Invalid path for `get_file_version` function  
[fix] Fix issue where block based checkout fields weren't working for the guest users  

2024-05-16 - version 2.3.0  
[fix] Fix bug where validation message appears on the Specific Date even when its empty  
[fix] Order meta key migration causing server resources issue  
[fix] Blocks assets missing from the compiled zip  
[fix] Don't send reminder emails for Orders with excluded products, categories and shipping methods  

2024-05-16 - version 2.2.0  
[new] Compatibility with Checkout Blocks  
[update] Make Edit Timeslot flexible so they can be used anywhere on the Thank you page with custom code snippet  
[update] Add dynamic notice to the Position field  
[fix] Added filter `iconic_wds_skip_cookie` to be complaint with cookie consent plugins  
[fix] Allow 24:00 in the timeslot To Time setting  
[fix] Design for the Edit Timeslot popup for Astra theme  
[fix] Fatal error when used with Table Rate Shipping plugin  

2024-04-10 - version 2.1.0  
[fix] Fatal error caused by Table Rate Shipping Method compatibility code  
[fix] Bug where admin cannot edit timeslot for customer order from the WP Dashboard  

2024-03-14 - version 2.0.0  
[new] Update timeslots directly from the Order Received page. This enhancement ensures compatibility with Express Payment methods such as Google Pay, Apple Pay, etc   
[update] Allow selected timeslot separator to be modified  
[update] Increase data limit for order id column in database  
[fix] Localize timeslot in site language  
[fix] Make Reservation table labels translatable  
[fix] Excluding product doesn't work when 'Auto-select first available date' is enabled  
[fix] Issue where shipping details (custom days, lead time) was not saving for custom product type  
[fix] Ordering not working when filtered by delivery date  
[fix] Bug where validation error is bypassed if the Checkout button is pressed second time  
[fix] Cache shipping method object in WC > Orders page to reduce SQL queries  
[new] Exclude products from max order limit  
[fix] Restore value of selected timeslot when address is changed  

2023-08-31 - version 1.24.1  
[fix] Fix license validation issues and type errors  

2023-08-24 - version 1.24.0  
[new] New Licensing system  
[update] Breaking change: Updated the order meta keys. This could potentially break your custom code snippets or 3rd party plugins that rely on delivery slots order meta. Refer to the [database structure](https://iconicwp.com/docs/woocommerce-delivery-slots/database-structure-2/) for the complete list of meta keys.
[update] New filter `iconic_wds_fee_amount`  
[update] Add timeslot argument to `iconic_wds_timeslot_shipping_method_allowed` filter  
[fix] `FILTER_SANITIZE_STRING` is deprecated warnings in PHP 8.1  
[fix] Admin: JS error when shipping method is not available for the given address  

2023-07-25 - version 1.23.0  
[fix] Fee not working when Auto-select First Timeslot setting is enabled  

2023-07-21 - version 1.22.1  
[update] Updated Iconic dependencies  
[fix] Admin: Missing datepicker icons  

2023-07-05 - version 1.22.0  
[update] Compatibility with `WooCommerce Phone Orders & Manual Orders` plugin  
[fix] JS error on the checkout page when a slot is reserved  
[fix] Delivery date filtering is not working on the admin orders page  
[fix] Issue where matching shipping method IDs would cause incorrect timeslots to appear for some dates  
[fix] False max order error on checkout  
[fix] JS Error related to vueConciseSlider  

2023-05-29 - version 1.21.0  
[new] HPOS Compatiblity  
[new] Added `iconic-wds-fields` shortcode and a setting to disable the position of delivery slots fields  
[new] Allow admin to cutoff timeslot based on timeslot's end time  
[fix] Issue with the reserved slot not carrying to the checkout page in non-english websites  
[fix] Fix fatal issue caused by invalid holiday date  
[fix] Check for non-existent meta key values when sorting orders by delivery column  
[fix] Reduce AJAX calls on date change  
[fix] Override settings checkbox not working  
[fix] Auto select first date not working when bookable dates are empty on page load  

2023-02-22 - version 1.20.0  
[new] Revamped Admin UI  
[update] Add filter for override tax class for delivery slots fee: `iconic_wds_fee_tax_class`  
[update] Use maximum lead time when there are multiple products with lead time in the cart  
[fix] Fix typo on Add product category page  
[fix] JS error in the console related to VueJS  

2022-12-15 - version 1.19.0  
[update] Do not completely disable the datepicker if the overriding products in cart have common days  
[update] Make Reservation Table dynamically initiatable with custom event `iconic_wds_init_reservation_table`  
[update] Automatically initialise reservation table on Elementor Popup  
[update] Add JS filters to allow postcode, city, state fields to be hidden in Reservation Table  
[update] Make "delivery" string in reservation table translatable  
[update] Add filter `iconic_wds_get_lead_time` to modify lead time  
[fix] Specific date not respecting lead time setting  
[fix] All dates appear bookable when ASAP is enabled  
[fix] Reservation calendar - state field cannot be updated  
[fix] Issue where shipping method would reset to the first one  
[fix] JS Error when used with CheckoutWC  
[fix] Fix warning when reserved timeslot data is incorrect  
[fix] Fix fatal error with `PDF Invoices & Packing Slips for WooCommerce` by WP Overnight  
[fix] Timeslot validation on Multistep checkout plugins  

2022-06-01 - version 1.18.0  
[new] Getting started tab  
[new] Add import/export settings feature  
[new] Compatibility with WooCommerce Cart All in One by VillaTheme  
[update] Added filter `iconic_wds_force_load_reservation_calendar_assets` to force load reservation calendar assets  
[fix] Translate "None selected" string  
[fix] Issue where 0 day fees might not appear as "Free"  
[fix] Accept HTML entities for shipping method in Reservation Calendar  
[fix] Scroll to top on reserving a timeslot in reservation table  
[fix] Issue where sometimes the first timeslot cannot be booked in the reservation table  
[fix] Fix issues with Reservation calendar and Checkout field editor plugin  
[fix] Issue where incorrect currency appears in the datepicker tooltip  
[fix] Issue where the Submit button is blocked on Customer Payment page   
[fix] Added check for empty specific date  
[fix] translation issue with the Reservation table  
[fix] Add check for same/next day cutoff during checkout validation  
[fix] Allow zero value to be entered in day max orders  
[fix] Issue where product overriden allowed days setting doesn't apply for specific days  

2022-03-03 - version 1.17.0  
[new] Add new shortcode `[iconic-wds-lead-time]` and `[iconic-wds-allowed-days]`  
[update] Add permission_callback to custom rest api routes  
[Update] New argument `shipping_method` added for reservation calendar shortcode  
[fix] Compatibility with PayPal Express Checkout plugin by WebToffee  
[fix] Translation issues with Reservation Calendar  
[fix] Correct timeslot value in Deliveries page when timeslot is "ASAP"  

2022-02-23 - version 1.16.0  
[new] Reservation calendar revamp  
[new] Added Feature to override Delivery Days and Minimum Selectable date per product and category  
[new] New REST API endpoints: `get_bookable_dates`, `get_slots_on_date`  
[new] New Feature: auto select first available date and timeslot  
[new] Add JS tooltip for the datepicker to indicate additional fees  
[update] Compatibility with select2 library  
[fix] Bug where Paypal payment gateway would validate even when WDS fields are hidden  

2021-11-01 - version 1.15.1  
[fix] Fix issue where the days selected in timeslot settings are inaccurately represented in the frontend  

2021-10-13 - version 1.15.0  
[update] Disable checkout when no dates are available  
[update] Add `$calculation` argument to `iconic_wds_is_day_allowed` filter  
[update] improved Compatibility with WooCommerce Paypal Payments plugin  
[fix] Fix intermittent issue where slots can't be booked from the reservation table  
[fix] Prevent fatal error when editing a post with reservation table shortcode  
[fix] Fix bug in reservation table that incorrectly used 'allowed day' settings for adjacent days in some timezones  
[fix] Reservation calendar: Prevent error when using with Block Editor  
[fix] Fix compatibility issue with Barn2 Lead Time plugin where visiting order page in the admin would cause a fatal error  
[fix] fix issue where timeslots appear in GMT instead of local timezone  
[fix] Fix Time slot field validation issue for Multi-step checkout plugin  
[fix] Fix typo in settings  
[fix] Compatibility with `WooCommerce PayPal Payments` plugin  
[fix] Fix issue where fees is not applied on the cart after reserving a slot from the Reservation Table  

2021-06-29 - version 1.14.0  
[new] Max orders calculation by number of products sold _or_ orders placed  
[update] Reduce AJAX calls on checkout by incorporating bookable dates into the WC fragments  
[update] Update dependencies  
[fix] Fix issue where next day cut-off wouldn't work as expected when used with minimum selectable date  

2021-03-16 - version 1.13.4  
[new] New shortcode `[iconic-wds-reserved-slot]`  
[new] Add new 'iconic_wds_same_day_cutoff' and 'iconic_wds_next_day_cutoff' filters  
[update] Compatibility with CheckoutWC  
[update] Ensure checkout doesn't proceed when no shipping method is selected  
[update] Display "no slots available" message instead of empty reservation table  
[fix] Incorrect timeslot label when slot duration is zero  
[fix] Avoid duplicate dates in reservation table  
[fix] Use "all" minmax method when no selected days  
[fix] Fix row ID issue which can replace "Sunday" with specific date in time slot settings  
[fix] Fix incorrect Max selectable date issue  
[fix] Correct same/next day calculations based on local time  

2020-11-13 - version 1.13.3  
[fix] Ensure default data has unique row IDs  

2020-11-12 - version 1.13.2  
[update] Allow holidays to be shipping method specific  
[update] Admin Deliveries page: Dynamically determine 'Today' and 'Tomorrow'  
[update] Update POT file  
[fix] Ensure datepicker fields are reindexed  
[fix] Fix issue where extra date was added to calendar if there was a holiday during the min/max calculation  

2020-11-09 - version 1.13.1  
[update] Ensure default settings work correctly  
[fix] Fix "needs shipping" check  
[fix] Stop specific dates showing for time slots once removed  

2020-11-06 - version 1.13.0  
[new] Assign time slots to specific delivery days  
[update] Change "All" logic for "Exclude Category Condition"  
[update] Update old jQuery methods  
[update] Updated POT file  
[update] Updated dependencies  
[fix] Avoid infinite loop for next day calculation  
[fix] Cast shipping methods to string for comparisons  
[fix] Duplicate field prevents saving admin date/time  
[fix] Remove hidden field label in admin order view  

2020-10-21 - version 1.12.0  
[new] Set specific delivery dates  
[update] Allow no delivery days to be selected  
[update] Update dependencies  
[update] Update WooCommerce Advanced Shipping compatibility  
[update] Update POT file  
[fix] Add time slot unique IDs to prevent conflicts when modifying time slots  
[fix] Ensure holiday dates are formatted on save  

2020-09-23 - version 1.11.2  
[new] Compatibility with Multi-step checkout for WooCommerce  
[update] Update dependencies  
[update] Setting to display checkout fields even when shipping is not required  
[update] Change date format for Holiday datepicker  
[update] Show message if trying to use reservation table with time slots disabled  
[update] Display date/time in order summary table after checkout for consistency  
[fix] Fix missing iconic_wds_min_delivery_date and iconic_wds_max_delivery_date filters  
[fix] Reservation table styling issues  
[fix] Fix issue with WooCommerce Advanced Free Shipping plugin  
[fix] Fix issue when order can be submitted without date/time  
[fix] Ensure date is also saved in database when time slot field is disabled  

2020-08-04 - version 1.11.1  
[update] Responsive deliveries table in admin  
[update] Update dependencies  
[update] Update POT file  
[fix] Holiday timezone issue  
[fix] Fix label issue when no shipping methods enabled  
[fix] Fix double reservation on failed order  
[fix] Fix remaining time slots calculation issue  
[fix] Fix admin bookable dates not matching frontend issue  
[fix] Check orders remaining for the day when time slots are disabled  

2020-07-03 - version 1.11.0  
[new] Holiday Repeat feature  
[new] Compatibility with [WooCommerce Lead Time](https://iconicwp.com/go/barn2-lead-time/)  
[update] Update dependencies  
[update] Update POT file  
[update] Better styling for "today" date in calendar  
[update] Set max date value for datepicker calendar  
[update] Update language files  
[update] Replace `iconic_wds_reservations_query` with `iconic_wds_reservations_pre_query` for security  
[fix] Holiday range end date  
[fix] Disable date/time fields when shipping address is not required  
[fix] Refine same day/next day methods  
[fix] Same day also disabled when next day was disabled  
[fix] Issue with wpsf_get_setting function in some instances  
[fix] Remove pdf links from reserved slots list in admin  
[fix] Max orders per day for same day delivery issue  
[fix] Holiday timezone issue  

2020-06-15 - version 1.10.0  
[new] 'Maximum Orders' setting for ASAP delivery  
[update] Add `iconic_wds_delivery_days_max_orders` filter  
[update] Compatiblity with `WooCommerce PDF Invoices & Packing Slips` plugin  
[fix] Fix maximum orders for 'ASAP' slot  
[fix] Prevent over-reserving slots  
[fix] Fix reservation table not showing all slots  
[fix] Ensure timestamps are checking the same timezone  
[fix] Sort timeslots in reservation calendar  
[fix] Enhance validation of date fields at checkout  
[fix] Further logic to prevent double-booking when order is placed at the same time  
[fix] Improved check for `iconic_wds_is_same_day_allowed` filter  
[fix] Improved check for `iconic_wds_is_next_day_allowed` filter  

2020-05-20 - version 1.9.2  
[new] Change labels between delivery/collection globally and per shipping method via the settings  
[update] Update dependencies  
[update] Added new filter `iconic_wds_timeslot_shipping_method_allowed`  
[update] Remove redundant status transitions method  
[fix] Prevent simultaneous double-booking  
[fix] Slots overbooked returning false positive when minus numbers  
[fix] Max orders for day not visible in admin  
[fix] Datepicker short day label localization issue  
[fix] Fix warning when chosen_method is null  
[fix] Fix nested ternary operator warning  
[fix] Fix undefined function `determine_locale` error  
[fix] Ensure shipping methods are cached  

2020-05-06 - version 1.9.1  
[update] Make time field type in admin "text"  
[update] Set slot duration AND slot frequency for dynamic time slots  
[fix] Unsupported opperand  

2020-05-05 - version 1.9.0  
[new] New datepicker styling - none, light, and dark  
[new] Ability to create slots dynamically  
[new] Set maximum orders per day  
[update] Improve method of toggling the date/time fields based on shipping method  
[update] Updated Dutch translations  
[update] Chronological order for delivery months in admin  
[update] Admin: Use shipping method title instead of type  
[update] Update dependencies  
[update] Reduced queries when counting slots available  
[update] Change default position of date/time fields at checkout  
[update] Add parameters to iconic_wds_available_dates filter  
[update] Update POT file  
[fix] Ensure correct shipping method is loaded on first change  
[fix] Correctly check translated days/months in datepicker  
[fix] Ensure orders can't be placed while delivery date/time is loading  
[fix] Locale issue in AJAX calls  
[fix] Prevent loading time slots too often at checkout  
[fix] Prevent time slots from loading multiple times if the date and shipping method are the same  
[fix] Disable the place order button if the date fields are still loading  
[fix] Fix infinite load on reservation table when no settings saved  
[fix] Undefined name/email for guest reserved slots in admin  

2020-04-23 - version 1.8.2  
[fix] First available date not matching  

2020-04-22 - version 1.8.1  
[update] Add setting to show/hide unavailable dates in the reservation table  
[update] Updated dependencies  
[fix] Only one reservation was allowed at a time  
[fix] Match available dates in lowercase to prevent mismatches (firefox/ie)  

2020-04-21 - version 1.8.0  
[new] Compatibility with CheckoutWC  
[new] [iconic-wds-get-order-date] shortcode  
[new] [iconic-wds-get-order-time] shortcode  
[new] [iconic-wds-get-order-date-time] shortcode  
[update] Update dependencies  
[fix] Fix `iconic_wds_max_delivery_date` filter  
[fix] Ensure chosen shipping method is cast as a string to prevent warning  
[fix] Make "All delivery dates" translatable in admin  
[fix] Fix CSS priority  

2020-03-18 - version 1.7.18  
[update] Version compatibility  

2019-12-18 - version 1.7.17  
[new] Add field to filter orders by delivery date  
[new] Add `All/Any` condition for Product and Category Exclude settings  
[update] Add `iconic_wds_get_cutoff` filter  
[update] Allow time slots to start and end at the same time. They'll be display as a single time instead of a range  
[update] Optimise is_timeslot_available_on_day()  
[update] Load reservation calender slots via AJAX to make compatibile with FastCGI and Redis cache  
[update] Add `iconic_wds_slots_available_on_date` filter  
[update] Update dependencies  
[update] Update POT file  
[fix] Fix instance of 'iconic_wds_next_day_date' filter  
[fix] Fix 'iconic_wds_allowed_days' filter  
[fix] Issue fetching meta when viewing reserved slots  

2019-07-01 - version 1.7.16  
[fix] Freemius Fix  

2019-03-02 - version 1.7.15  
[fix] Security Fix  
[fix] Headers already sent notice  

2018-12-06 - version 1.7.14  
[update] Compatibility with WP 5.0  
[update] Compatibility with Woo 3.5.2  
[update] Update dependencies  
[fix] Ensure fee is properly calculated when using date field only  
[fix] Restrict by category was not applied to variations  
[fix] Prevent infinite loop when there are no delivery days enabled  
[fix] Ensure date field is not translatable by Google Translate  

2018-10-26 - version 1.7.13  
[new] Ability to add fees to days of the week  
[update] Ensured compatibility with Woo 3.5.0  
[update] add_filter for get_reservations  
[update] Check WC is active before running unnecessary code  
[update] POT updated  
[fix] Remove shipping method watcher to fix delivery slot fields toggle  
[fix] Ensure settings page permissions work and allow them to be filtered  
[fix] When WC is deactivated the settings file tries to use a WC function causing a fatal error  
[fix] Fix conflict with bootstrap-date plugin  

2018-09-18 - version 1.7.12  
[update] add_filter for is_timeslot_available_on_day  
[fix] Calendar opens on wrong month when using mm/dd/yy format  
[fix] Ensure all dates use the correct formatting  
[fix] Fix issue when plugin loads via CLI/Cron  

2018-09-11 - version 1.7.11  
[new] Add WooCommerce Table Rate Shipping by WooCommerce compatibility  
[update] Same day/next day key on deliveries page  
[update] Allow "next day" to be "next allowed delivery day"  
[update] Start calendar on first available date  
[update] Hide time slot col in deliveries tab if not enabled  
[update] Implement Iconic core classes  
[update] Always display field descriptions if enabled  
[fix] API data was not being added  
[fix] Validate required time slot field at checkout  
[fix] Fix available delivery days when min/max method is all days  
[fix] Time slot required when not enabled  
[fix] Update reservation correctly when final order date is different  
[fix] All dates were disabled in the order details page  
[fix] Infinite loop caused when timeslots or reservations are not returned by the ajax request get_slots_on_date  
[fix] Sometimes the calendar opens the wrong month when the value is empty  
[fix] When we change shipping method refresh timeslots faster to prevent customers from submitting the checkout form with wrong timeslot

2018-07-06 - version 1.7.10  
[new] Add ASAP delivery same day cut off  
[new] Add ASAP delivery fee  
[new] Add same/next day fees to reservation table  
[change] Cache shipping method options  
[change] Add script debugging  
[change] Remove unnecessary update_checkout trigger  
[change] Change all hooks to use `iconic_wds_` prefix  
[change] Add `$order` object to some text filters  
[update] Update Freemius  
[fix] Use date format from settings when checking for fees  
[fix] Ensure fees in reservation table use `float` not `int`  
[fix] Add ASAP fee at checkout in dropdown  

2018-02-12 - version 1.7.9  
[update] French translation files  
[update] German translation files  
[update] Update Freemius  
[update] Update settings framework  
[update] Ability to disable delivery slots if product from specific category is in the cart  
[update] Ability to disable delivery slots if a specific product is in the cart  
[update] Remove Envato checks  
[update] Add ASAP delivery time slot  
[update] Update POT file  
[fix] PHP Error for < 5.5 "Can't use function return value in write context"  
[fix] Issue with stripe validation when fields are hidden  
[fix] Cast shipping method to string for "WooCommerce Advanced Shipping" compatibility  

2017-12-19 - version 1.7.8  
[update] Add delivery date meta to legacy API request  
[update] Change field validation method at checkout  
[update] Updated pot file  
[update] Disable time slots while loading  
[fix] Make sure fields are validated by Stripe Gateway  
[fix] Prevent current date being selected on field reset  
[fix] Incorrect name for DE .po file  
[fix] Blank page when creating a new order in the admin

2017-11-07 - version 1.7.7  
[update] Allow order delivery date to be modified by admin  
[update] Trigger datepicker onSelect on checkout load  
[update] Validate shipping method settings  
[update] Add fees for same day/next day deliveries  
[update] Freemius  
[update] add_filter for date and time display  
[update] Add Flexible Shipping for WooCommerce compatibility  
[update] Add \[iconic-wds-next-delivery-date\] shortcode  
[update] Allow slot lockout to be "0"  
[update] Add some validation for min/max selectable date settings  
[update] Update POT file  
[fix] Remove reserved slot when order is cancelled  
[fix] Prevent dodgy characters in calendar  
[fix] Get correct timestamp for removing outdated reservations  
[fix] Make sure hidden field value is populated correctly at checkout  
[fix] Issue with deleting expired reservations  
[fix] Issue with duplicated slots at checkout

2017-07-07 - version 1.7.6  
[update] Reselect timeslot on order details refresh

2017-07-07 - version 1.7.5  
[update] Implement new licence system  
[update] Add compatibility for BE cart based shipping  
[update] Add compatibility for Distance rate Shipping by WPShowCase  
[fix] Cancelled deliveries showing as dashes on deliveries admin page

2017-04-02 - version 1.7.4  
[update] Compatibility with WooCommerce 3.0.0  
[update] Compatibility with WooCommerce Advanced Free Shipping  
[update] Add delivery data to the API response  
[update] Moved ajax functions to their own class  
[fix] Use WordPress date format in deliveries tab

2016-12-22 - version 1.7.3  
[update] Strip out old code for postcode functionality  
[update] Settings framework  
[update] Envato market updater  
[update] Update minimum selectable date logic to account for current day if it is non-deliverable  
[update] Add filters for min/max delivery date  
[update] Hebrew translation (thanks Guy)  
[update] Add filters to text strings  
[fix] Remove data-icon CSS  
[fix] Option to calculate tax on timeslot fee  
[fix] Fix German language files and update

2016-07-28 - version 1.7.2  
[update] Add "Allow Bookings up to X Minutes Before Slot" to each timeslot. Overrides default.  
[update] Delete reservation when order is cancelled or deleted  
[update] Compatibility with "Table Rate Shipping Plus" by "mangohour"  
[update] Reduce database interactions for slot lookup  
[update] Update settings framework   
[fix] Add new parameter to email_order_delivery_details  
[update] Add new actions/filters to the checkout fields template

2016-07-07 - version 1.7.1  
[fix] Compatibility with latest Multi Step Checkout plugin  
[update] Compatibility with latest "Table Rate Shipping" plugin  
[fix] Compatibility with latest "WooCommerce Advanced Shipping" plugin

2016-06-27 - version 1.7.0  
[update] Compatibility with new Shipping Zones  
[update] New time slot conditional - show slots for specific shipping zones only  
[update] Selectable dates will change based on selected shipping method  
[update] Allow holidays to be entered as a range of days  
[update] Set calendar to open on first available date

2016-06-16 - version 1.6.3  
[fix] Issue with far out timezones and same/next day deliveries  
[update] Settings framework  
[update] Set calendar to reflect last day of the week setting  
[update] Move same day / next day cut off to date tab, instead of time slot tab  
[fix] Issue where date only wasn't working if no time slots were present

2016-05-17 - version 1.6.2  
[fix] Allowed days not setting correctly  
[update] Restrict dates to current week  
[update] Allow admin orders to be sorted by delivery date (new orders only)  
[fix] Allow bookings up to x minutes before slot was only accounting for the current day

2016-04-22 - version 1.6.1  
[update] Add WooShip compatibility  
[fix] Issue when using wpcli  
[fix] Not working on multisite  
[update] Add option to format reservation table date heading  
[fix] Add class if fields are disabled on load to make the initial check more accurate

2016-04-19 - version 1.6.0  
[fix] Sometimes an issue loading datepicker at checkout - changed to $(window).load();  
[update] Update to new settings framework

2016-01-14 - version 1.5.10  
[fix] Allow more than 66 for max date  
[fix] Trigger change event is timeslots are not in use

2015-12-08 - version 1.5.9  
[fix] Remove nonce check on ajax methods to avoid cache issues  
[update] Trigger select change when loading new slots  
[update] Add version to enqueued scripts

2015-12-08 - version 1.5.8  
[fix] Optimise get_timeslot_data as it was slowing down with a lot of timeslots  
[fix] Only select reservation if it's available in checkout dropdown  
[fix] min/Max were ignoring timezone  
[fix] Remove forward slash on some includes  
[update] Multi Step Checkout compatibility

2015-11-25 - version 1.5.7  
[fix] Sunday being ignored as allowed day

2015-11-25 - version 1.5.6  
[fix] Email order meta, and better styling  
[update] Remove : from time slot fee text  
[fix] Orders with 'date only' now show in deliveries tab  
[fix] Issue if user places delivery for slot they've already used, unlikely, but avoided the issue just in case  
[fix] Trashed orders were showing in the deliveries tab  
[fix] Issue where you could proceed through checkout if slots hadn't finished loading  
[update] Add validation to "Allow Bookings up to..." field  
[update] Min/Max selectable date methods - now you can choose from allowed days, weekdays, or all days  
[update] Disable same day/next day if current time is after (x)  
[update] Change wording to time slot instead of timeslot in some strings  
[update] POT file

2015-11-23 - version 1.5.5  
[fix] Current day not showing in upcoming deliveries tab  
[fix] Missing text domain on one string

2015-11-13 - version 1.5.4  
[fix] Lock time slot on current day if passed

2015-11-11 - version 1.5.3  
[update] Reservation table - group timeslots with the same time so you can have different prices on different days  
[update] Dutch translation  
[fix] Holidays not working if not in English

2015-11-03 - version 1.5.2  
[update] Add "any" shipping method option, to always display fields  
[update] Use billing postcode for lookup if shipping is disabled or missing  
[fix] Fix timeslot display if logged out on checkout  
[update] German translation

2015-10-26 - version 1.5.1  
[fix] Change "add fee" priority so it works with storefront and other themes  
[fix] Checkout fields when only one shipping method, or no shipping method

2015-10-25 - version 1.5.0  
[update] Fee per timeslot  
[fix] Fixed reservation table  
[update] Reservations can now be made by logged out users (Note: ID format changed, so may not work well with existing reservations)  
[fix] Show/hide for radio or select options  
[fix] Use WordPress time functions so if the timezone is UTC it does not cause any issues  
[update] Add delivery details column to admin order listing  
[update] New icons  
[update] Compatibility with WooCommerce Advanced Shipping  
[update] Compatibility with WooCommerce Table Rate Shipping  
[update] Min/max bookable dates account for allowed days only now  
[update] Allow date and time to be moved in checkout  
[fix] Email encoding

2015-10-10 - version 1.4.0  
[update] Show/hide based on shipping method  
[update] Refactor and tidy javascript

2015-07-10 - version 1.3.0  
[update] Postcode Restrictions (See "Postcode Restrictions" https://jamesckemp.ticksy.com/article/4560/) special thanks to dullejohn  
[update] Added da_DK translation special thanks to dullejohn  
[update] Translation files updated

2015-07-10 - version 1.2.3  
[update] French - Updated translation

2015-07-07 - version 1.2.2  
[update] Portuguese - Brazil translation

2015-07-06 - version 1.2.1  
[fix] Missing languages folder  
[update] New translations available

2015-06-26 - version 1.2.0  
[update] New po file for translations  
[update] More strings available to translate  
[update] esc_attr  
[update] z-index for datepicker  
[fix] in_array notice  
[update] Moved labels to translatable strings for convenience  
[fix] Remove text domain as variable  
[update] Check PHP version  
[update] Added some settings validation to prevent common issues  
[update] Disable timeslot field while loading  
[update] hide timeslot field until date is chosen

2015-06-10 - version 1.1.1  
[Update] Allow HTTPS

2015-05-11 - version 1.1.0  
[Fix] Allow shop managers to save options  
[Update] Convert to SCSS - Dev only  
[Update] Move dynamic styles to head tag for speed  
[Update] Add note about where to view themes for datepicker

2015-02-23 - version 1.0.9  
[Fix] Change error output function to fix checkout issue

2014-11-11 - version 1.0.8  
[fix] Change indexOf method so it works in IE8  
[fix] Add check for WooCommerce so no errors when updating  
[fix] Validation of fields at checkout

2014-10-28 - version 1.0.7  
[Update] Change date field to be read only

2014-10-27 - version 1.0.6  
[Fix] Delivery settings page permissions  
[Fix] Delivery times chosen at checkout will now appear on the Deliveries tab

2014-08-08 - version 1.0.5  
[Update] Only use ui styles on checkout page  
[Fix] Fixed timezone issue. Make sure this is set in WP Settings to a string.

2014-08-07 - version 1.0.4  
[Fix] Fixed checkbox issue not saving certain days in slots

2014-07-14 - version 1.0.3  
[Update] Added "time blocking". if the time has passed for the current day, the slot becomes unavailable.  
[Update] Added the ability to set slots to apply for specific days only.  
[Update] Added "Allow Bookings Up To (x) Minutes Before Slot" functionality.  
[Update] Updated table shortcode to allow logged out users to see how many slots are remaining for each timeslot.  
[Fix] Updated Table shortcode to prevent border glitch when loading icon is displayed.

2014-06-29 - version 1.0.2  
[Update] Added PO files for translation

2014-05-06 - version 1.0.1  
[Update] Time format option  
[Update] Upcoming Deliveries page  
[Fix] Order meta labels in customer emails  
[Update] Added trigger to body after timeslots are loaded in checkout  
[Update] Added triggers on body to reservation table after remove and add

2014-03-29 - version 1.0.0  
Initial Release