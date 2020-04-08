<?php

class ImportController extends BaseController {

    public function __construct() {
        if (empty(Session::get('lang'))) {
            Session::put('lang', 'en');
        }

        $locale = Session::get('lang');
        App::setLocale($locale);
    }

    public function showView($name) {
        if (View::exists($name)) {
            return View::make($name);
        } else {
            if (Session::get('lang') == "en") {
                $viewData = array(
                    'title' => "Page not found!",
                    'panel_nav_active' => '',
                    'main_nav_active' => '',
                    'sub_nav_active' => '',
                    'image' => ""
                );
                return View::make('404_en', $viewData);
            } else {
                $viewData = array(
                    'title' => "Halaman tidak dijumpai!",
                    'panel_nav_active' => '',
                    'main_nav_active' => '',
                    'sub_nav_active' => '',
                    'image' => ""
                );
                return View::make('404_my', $viewData);
            }
        }
    }

    public function importCOBFile() {
        if (Request::ajax()) {
            $file = Input::file('import_file');
            $company_id = Input::get('import_company');
            if ($file) {
                $path = $file->getRealPath();
                $data = Excel::load($path, function($reader) {
                            
                        })->get();

                if (!empty($data) && $data->count()) {
                    foreach ($data->toArray() as $row) {
                        if (!empty($row)) {
                            // Nombor Fail
                            $file_no = '';
                            if (isset($row['1']) && !empty($row['1'])) {
                                $file_no = trim($row['1']);
                            }
                            // Tahun
                            $year = '';
                            if (isset($row['2']) && !empty($row['2'])) {
                                $year = trim($row['2']);
                            }
                            // Status
                            $is_active = 0;
                            if (isset($row['64']) && !empty($row['64'])) {
                                $is_active_raw = trim($row['64']);

                                if (!empty($is_active_raw)) {
                                    if ($is_active_raw == 'AKTIF') {
                                        $is_active = 1;
                                    }
                                }
                            }


                            if (!empty($file_no)) {
                                $check_file = Files::where('company_id', $company_id)->where('file_no', $file_no)->where('is_deleted', 0)->count();
                                if ($check_file <= 0) {
                                    $files = new Files();
                                    $files->company_id = $company_id;
                                    $files->file_no = $file_no;
                                    $files->year = $year;
                                    $files->is_active = $is_active;
                                    $files->status = 1;
                                    $files->approved_by = Auth::user()->id;
                                    $files->approved_at = date('Y-m-d H:i:s');
                                    $files->created_by = Auth::user()->id;
                                    $create_file = $files->save();

                                    if ($create_file) {
                                        // Nama
                                        $name = '';
                                        if (isset($row['3']) && !empty($row['3'])) {
                                            $name = trim($row['3']);
                                        }
                                        // Pemaju
                                        $developer = '';
                                        if (isset($row['4']) && !empty($row['4'])) {
                                            $developer_raw = trim($row['4']);

                                            if (!empty($developer_raw)) {
                                                $developer_query = Developer::where('name', $developer_raw)->where('is_deleted', 0)->first();
                                                if ($developer_query) {
                                                    $developer = $developer_query->id;
                                                } else {
                                                    $developer_query = new Developer();
                                                    $developer_query->name = $developer_raw;
                                                    $developer_query->is_active = 1;
                                                    $developer_query->save();

                                                    $developer = $developer_query->id;
                                                }
                                            }
                                        }
                                        // Alamat 1
                                        $address1 = '';
                                        if (isset($row['5']) && !empty($row['5'])) {
                                            $address1 = trim($row['5']);
                                        }
                                        // Alamat 2
                                        $address2 = '';
                                        if (isset($row['6']) && !empty($row['6'])) {
                                            $address2 = trim($row['6']);
                                        }
                                        // Alamat 3
                                        $address3 = '';
                                        if (isset($row['7']) && !empty($row['7'])) {
                                            $address3 = trim($row['7']);
                                        }
                                        // Alamat 4
                                        $address4 = '';
                                        if (isset($row['8']) && !empty($row['8'])) {
                                            $address4 = trim($row['8']);
                                        }
                                        // Poskod
                                        $postcode = '';
                                        if (isset($row['9']) && !empty($row['9'])) {
                                            $postcode = trim($row['9']);
                                        }
                                        // Bandar
                                        $city = '';
                                        if (isset($row['10']) && !empty($row['10'])) {
                                            $city_raw = trim($row['10']);

                                            if (!empty($city_raw)) {
                                                $city_query = City::where('description', $city_raw)->where('is_deleted', 0)->first();
                                                if ($city_query) {
                                                    $city = $city_query->id;
                                                } else {
                                                    $city_query = new City();
                                                    $city_query->description = $city_raw;
                                                    $city_query->is_active = 1;
                                                    $city_query->save();

                                                    $city = $city_query->id;
                                                }
                                            }
                                        }
                                        // Negeri
                                        $state = '';
                                        if (isset($row['11']) && !empty($row['11'])) {
                                            $state_raw = trim($row['11']);

                                            if (!empty($state_raw)) {
                                                $state_query = State::where('name', $state_raw)->where('is_deleted', 0)->first();
                                                if ($state_query) {
                                                    $state = $state_query->id;
                                                } else {
                                                    $state_query = new State();
                                                    $state_query->name = $state_raw;
                                                    $state_query->is_active = 1;
                                                    $state_query->save();

                                                    $state = $state_query->id;
                                                }
                                            }
                                        }
                                        // Negara
                                        $country = '';
                                        if (isset($row['12']) && !empty($row['12'])) {
                                            $country_raw = trim($row['12']);

                                            if (!empty($country_raw)) {
                                                $country_query = Country::where('name', $country_raw)->where('is_deleted', 0)->first();
                                                if ($country_query) {
                                                    $country = $country_query->id;
                                                } else {
                                                    $country_query = new Country();
                                                    $country_query->name = $country_raw;
                                                    $country_query->is_active = 1;
                                                    $country_query->save();

                                                    $country = $country_query->id;
                                                }
                                            }
                                        }
                                        // No. Telefon
                                        $phone_no = '';
                                        if (isset($row['13']) && !empty($row['13'])) {
                                            $phone_no = trim($row['13']);
                                        }
                                        // No. Fax
                                        $fax_no = '';
                                        if (isset($row['14']) && !empty($row['14'])) {
                                            $fax_no = trim($row['14']);
                                        }

                                        $house_scheme = new HouseScheme();
                                        $house_scheme->file_id = $files->id;
                                        $house_scheme->name = $name;
                                        $house_scheme->developer = $developer;
                                        $house_scheme->address1 = $address1;
                                        $house_scheme->address2 = $address2;
                                        $house_scheme->address3 = $address3;
                                        $house_scheme->address4 = $address4;
                                        $house_scheme->poscode = $postcode;
                                        $house_scheme->city = $city;
                                        $house_scheme->state = $state;
                                        $house_scheme->country = $country;
                                        $house_scheme->phone_no = $phone_no;
                                        $house_scheme->fax_no = $fax_no;
                                        $house_scheme->is_active = 1;
                                        $house_scheme->save();

                                        // Strata Scheme Status
                                        // Strata Title
                                        // Strata
                                        $strata_name = '';
                                        if (isset($row['17']) && !empty($row['17'])) {
                                            $strata_name = trim($row['17']);
                                        }
                                        // Parlimen
                                        $parliament = '';
                                        if (isset($row['18']) && !empty($row['18'])) {
                                            $parliament_raw = trim($row['18']);

                                            if (!empty($parliament_raw)) {
                                                $parliament_query = Parliment::where('description', $parliament_raw)->where('is_deleted', 0)->first();
                                                if ($parliament_query) {
                                                    $parliament = $parliament_query->id;
                                                } else {
                                                    $parliament_query = new Parliment();
                                                    $parliament_query->description = $parliament_raw;
                                                    $parliament_query->is_active = 1;
                                                    $parliament_query->save();

                                                    $parliament = $parliament_query->id;
                                                }
                                            }
                                        }
                                        // DUN
                                        $dun = '';
                                        if (isset($row['19']) && !empty($row['19'])) {
                                            $dun_raw = trim($row['19']);

                                            if (!empty($dun_raw)) {
                                                $dun_query = Dun::where('parliament', $parliament)->where('description', $dun_raw)->where('is_deleted', 0)->first();
                                                if ($dun_query) {
                                                    $dun = $dun_query->id;
                                                } else {
                                                    $dun_query = new Dun();
                                                    $dun_query->parliament = $parliament;
                                                    $dun_query->description = $dun_raw;
                                                    $dun_query->is_active = 1;
                                                    $dun_query->save();

                                                    $dun = $dun_query->id;
                                                }
                                            }
                                        }
                                        // Taman
                                        $park = '';
                                        if (isset($row['20']) && !empty($row['20'])) {
                                            $park_raw = trim($row['20']);

                                            if (!empty($park_raw)) {
                                                $park_query = Park::where('dun', $dun)->where('description', $park_raw)->where('is_deleted', 0)->first();
                                                if ($park_query) {
                                                    $park = $park_query->id;
                                                } else {
                                                    $park_query = new Park();
                                                    $park_query->dun = $dun;
                                                    $park_query->description = $park_raw;
                                                    $park_query->is_active = 1;
                                                    $park_query->save();

                                                    $park = $park_query->id;
                                                }
                                            }
                                        }
                                        // Alamat 1
                                        $strata_address1 = '';
                                        if (isset($row['21']) && !empty($row['21'])) {
                                            $strata_address1 = trim($row['21']);
                                        }
                                        // Alamat 2
                                        $strata_address2 = '';
                                        if (isset($row['22']) && !empty($row['22'])) {
                                            $strata_address2 = trim($row['22']);
                                        }
                                        // Alamat 3
                                        $strata_address3 = '';
                                        if (isset($row['23']) && !empty($row['23'])) {
                                            $strata_address3 = trim($row['23']);
                                        }
                                        // Alamat 4
                                        $strata_address4 = '';
                                        if (isset($row['24']) && !empty($row['24'])) {
                                            $strata_address4 = trim($row['24']);
                                        }
                                        // Poskod
                                        $strata_postcode = '';
                                        if (isset($row['25']) && !empty($row['25'])) {
                                            $strata_postcode = trim($row['25']);
                                        }
                                        // Bandar
                                        $strata_city = '';
                                        if (isset($row['26']) && !empty($row['26'])) {
                                            $strata_city_raw = trim($row['26']);

                                            if (!empty($strata_city_raw)) {
                                                $strata_city_query = City::where('description', $strata_city_raw)->where('is_deleted', 0)->first();
                                                if ($strata_city_query) {
                                                    $strata_city = $strata_city_query->id;
                                                } else {
                                                    $strata_city_query = new City();
                                                    $strata_city_query->description = $strata_city_raw;
                                                    $strata_city_query->is_active = 1;
                                                    $strata_city_query->save();

                                                    $strata_city = $strata_city_query->id;
                                                }
                                            }
                                        }
                                        // Negeri
                                        $strata_state = '';
                                        if (isset($row['27']) && !empty($row['27'])) {
                                            $strata_state_raw = trim($row['27']);

                                            if (!empty($strata_state_raw)) {
                                                $strata_state_query = State::where('name', $strata_state_raw)->where('is_deleted', 0)->first();
                                                if ($strata_state_query) {
                                                    $strata_state = $strata_state_query->id;
                                                } else {
                                                    $strata_state_query = new State();
                                                    $strata_state_query->name = $strata_state_raw;
                                                    $strata_state_query->is_active = 1;
                                                    $strata_state_query->save();

                                                    $strata_state = $strata_state_query->id;
                                                }
                                            }
                                        }
                                        // Negara
                                        $strata_country = '';
                                        if (isset($row['28']) && !empty($row['28'])) {
                                            $strata_country_raw = trim($row['28']);

                                            if (!empty($strata_country_raw)) {
                                                $strata_country_query = Country::where('name', $strata_country_raw)->where('is_deleted', 0)->first();
                                                if ($strata_country_query) {
                                                    $strata_country = $strata_country_query->id;
                                                } else {
                                                    $strata_country_query = new Country();
                                                    $strata_country_query->name = $strata_country_raw;
                                                    $strata_country_query->is_active = 1;
                                                    $strata_country_query->save();

                                                    $strata_country = $strata_country_query->id;
                                                }
                                            }
                                        }
                                        // Bilangan Blok
                                        $block_no = '';
                                        if (isset($row['29']) && !empty($row['29'])) {
                                            $block_no = trim($row['29']);
                                        }
                                        // Daerah
                                        $town = '';
                                        if (isset($row['30']) && !empty($row['30'])) {
                                            $town_raw = trim($row['30']);

                                            if (!empty($town_raw)) {
                                                $town_query = City::where('description', $town_raw)->where('is_deleted', 0)->first();
                                                if ($town_query) {
                                                    $town = $town_query->id;
                                                } else {
                                                    $town_query = new City();
                                                    $town_query->description = $town_raw;
                                                    $town_query->is_active = 1;
                                                    $town_query->save();

                                                    $town = $town_query->id;
                                                }
                                            }
                                        }
                                        // Kawasan
                                        $area = '';
                                        if (isset($row['31']) && !empty($row['31'])) {
                                            $area_raw = trim($row['31']);

                                            if (!empty($area_raw)) {
                                                $area_query = Area::where('description', $area_raw)->where('is_deleted', 0)->first();
                                                if ($area_query) {
                                                    $area = $area_query->id;
                                                } else {
                                                    $area_query = new Area();
                                                    $area_query->description = $area_raw;
                                                    $area_query->is_active = 1;
                                                    $area_query->save();

                                                    $area = $area_query->id;
                                                }
                                            }
                                        }
                                        // Luas Tanah
                                        $land_area = '';
                                        if (isset($row['32']) && !empty($row['32'])) {
                                            $land_area = trim($row['32']);
                                        }
                                        // Pemfailan Unit Syer
                                        $total_share_unit = '';
                                        if (isset($row['33']) && !empty($row['33'])) {
                                            $total_share_unit = trim($row['33']);
                                        }
                                        // Unit Ukuran
                                        $land_area_unit = '';
                                        if (isset($row['34']) && !empty($row['34'])) {
                                            $land_area_unit = trim($row['34']);
                                        }
                                        // No. Lot
                                        $lot_no = '';
                                        if (isset($row['35']) && !empty($row['35'])) {
                                            $land_area_unit = trim($row['35']);
                                        }
                                        // Tingkat
                                        $total_floor = '';
                                        if (isset($row['36']) && !empty($row['36'])) {
                                            $total_floor = trim($row['36']);
                                        }
                                        // Tarikh VP
                                        $vacant_date = '';
                                        if (isset($row['37']) && !empty($row['37'])) {
                                            $vacant_date = trim($row['37']);
                                        }
                                        // Tarikh CFO
                                        $ccc_date = '';
                                        if (isset($row['38']) && !empty($row['38'])) {
                                            $ccc_date = trim($row['38']);
                                        }
                                        // No. CFO
                                        $ccc_no = '';
                                        if (isset($row['39']) && !empty($row['39'])) {
                                            $ccc_no = trim($row['39']);
                                        }
                                        // Kategori Tanah 
                                        $land_title = '';
                                        if (isset($row['40']) && !empty($row['40'])) {
                                            $land_title_raw = trim($row['40']);

                                            if (!empty($land_title_raw)) {
                                                $land_title_query = LandTitle::where('description', $land_title_raw)->where('is_deleted', 0)->first();
                                                if ($land_title_query) {
                                                    $land_title = $land_title_query->id;
                                                } else {
                                                    $land_title_query = new LandTitle();
                                                    $land_title_query->description = $land_title_raw;
                                                    $land_title_query->is_active = 1;
                                                    $land_title_query->save();

                                                    $land_title = $land_title_query->id;
                                                }
                                            }
                                        }
                                        // Kategori
                                        $category = '';
                                        if (isset($row['41']) && !empty($row['41'])) {
                                            $category_raw = trim($row['41']);

                                            if (!empty($category_raw)) {
                                                $category_query = Category::where('description', $category_raw)->where('is_deleted', 0)->first();
                                                if ($category_query) {
                                                    $category = $category_query->id;
                                                } else {
                                                    $category_query = new Category();
                                                    $category_query->description = $category_raw;
                                                    $category_query->is_active = 1;
                                                    $category_query->save();

                                                    $category = $category_query->id;
                                                }
                                            }
                                        }

                                        // Kediaman
                                        $is_residential = 0;
                                        // Bilangan Unit
                                        $residential_unit_no = 0;
                                        if (isset($row['43']) && !empty($row['43'])) {
                                            $residential_unit_no = trim($row['43']);
                                        }
                                        if ($residential_unit_no > 0) {
                                            $is_residential = 1;
                                        }

                                        // Komersial
                                        $is_commercial = 0;
                                        // Bilangan Unit
                                        $commercial_unit_no = 0;
                                        if (isset($row['45']) && !empty($row['45'])) {
                                            $commercial_unit_no = trim($row['45']);
                                        }
                                        if ($commercial_unit_no > 0) {
                                            $is_commercial = 1;
                                        }

                                        $strata = new Strata();
                                        $strata->file_id = $files->id;
                                        $strata->name = $strata_name;
                                        $strata->parliament = $parliament;
                                        $strata->dun = $dun;
                                        $strata->park = $park;
                                        $strata->address1 = $strata_address1;
                                        $strata->address2 = $strata_address2;
                                        $strata->address3 = $strata_address3;
                                        $strata->address4 = $strata_address4;
                                        $strata->poscode = $strata_postcode;
                                        $strata->city = $strata_city;
                                        $strata->state = $strata_state;
                                        $strata->country = $strata_country;
                                        $strata->block_no = $block_no;
                                        $strata->total_floor = $total_floor;
                                        $strata->vacant_date = $vacant_date;
                                        $strata->town = $town;
                                        $strata->area = $area;
                                        $strata->land_area = $land_area;
                                        $strata->total_share_unit = $total_share_unit;
                                        $strata->land_area_unit = $land_area_unit;
                                        $strata->lot_no = $lot_no;
                                        $strata->ownership_no = '';
                                        $strata->date = '';
                                        $strata->land_title = $land_title;
                                        $strata->category = $category;
                                        $strata->perimeter = '';
                                        $strata->ccc_no = $ccc_no;
                                        $strata->ccc_date = $ccc_date;
                                        $strata->file_url = '';
                                        $strata->is_residential = $is_residential;
                                        $strata->is_commercial = $is_commercial;
                                        $create_strata = $strata->save();

                                        if ($create_strata) {
                                            $facility = new Facility();
                                            $facility->file_id = $files->id;
                                            $facility->strata_id = $strata->id;
                                            $facility->save();

                                            if ($is_residential) {
                                                $residential = new Residential();
                                                $residential->file_id = $files->id;
                                                $residential->strata_id = $strata->id;
                                                $residential->unit_no = $residential_unit_no;
                                                $residential->maintenance_fee = '';
                                                $residential->maintenance_fee_option = '';
                                                $residential->sinking_fund = '';
                                                $residential->sinking_fund_option = '';
                                                $residential->save();
                                            }

                                            if ($is_commercial) {
                                                $commercial = new Commercial();
                                                $commercial->file_id = $files->id;
                                                $commercial->strata_id = $strata->id;
                                                $commercial->unit_no = $commercial_unit_no;
                                                $commercial->maintenance_fee = '';
                                                $commercial->maintenance_fee_option = '';
                                                $commercial->sinking_fund = '';
                                                $commercial->sinking_fund_option = '';
                                                $commercial->save();
                                            }
                                        }

                                        // JMB
                                        $is_jmb = 0;
                                        // Tarikh Penubuhan
                                        $jmb_date_formed = '';
                                        if (isset($row['48']) && !empty($row['48'])) {
                                            $jmb_date_formed = trim($row['48']);
                                        }
                                        // No Siri Sijil
                                        $jmb_certificate_no = '';
                                        if (isset($row['49']) && !empty($row['49'])) {
                                            $jmb_certificate_no = trim($row['49']);
                                        }
                                        // Nama
                                        $jmb_name = '';
                                        if (isset($row['50']) && !empty($row['50'])) {
                                            $jmb_name = trim($row['50']);
                                        }
                                        if (!empty($jmb_name)) {
                                            $is_jmb = 1;
                                        }

                                        // MC
                                        $is_mc = 0;
                                        // Tarikh Penubuhan
                                        $mc_date_formed = '';
                                        if (isset($row['52']) && !empty($row['52'])) {
                                            $mc_date_formed = trim($row['52']);
                                        }
                                        // Certificate Series Number
                                        if (isset($row['53']) && !empty($row['53'])) {
                                            $mc_first_agm = trim($row['53']);
                                        }
                                        // Tarikh Mesyuarat Agong Pertama
                                        $mc_first_agm = '';
                                        if (isset($row['53']) && !empty($row['53'])) {
                                            $mc_first_agm = trim($row['53']);
                                        }
                                        // Nama
                                        $mc_name = '';
                                        if (isset($row['54']) && !empty($row['54'])) {
                                            $mc_name = trim($row['54']);
                                        }
                                        if (!empty($mc_name)) {
                                            $is_mc = 1;
                                        }

                                        // Ejen
                                        $is_agent = 0;
                                        // Lantikan
                                        $agent_selected_by = '';
                                        if (isset($row['56']) && !empty($row['56'])) {
                                            $agent_selected_by = trim($row['56']);
                                        }
                                        // Nama Ejen
                                        $agent_name = '';
                                        if (isset($row['57']) && !empty($row['57'])) {
                                            $agent_name = trim($row['57']);
                                        }
                                        if (!empty($agent_name)) {
                                            $is_agent = 1;
                                        }

                                        // Pelbagai
                                        $is_others = 0;
                                        // Nama
                                        $others_name = '';
                                        if (isset($row['59']) && !empty($row['59'])) {
                                            $others_name = trim($row['59']);
                                        }
                                        if (!empty($others_name)) {
                                            $is_others = 1;
                                        }

                                        $management = new Management();
                                        $management->file_id = $files->id;
                                        $management->is_jmb = $is_jmb;
                                        $management->is_mc = $is_mc;
                                        $management->is_agent = $is_agent;
                                        $management->is_others = $is_others;
                                        $create_management = $management->save();

                                        if ($create_management) {
                                            if ($is_jmb) {
                                                $new_jmb = new ManagementJMB();
                                                $new_jmb->file_id = $files->id;
                                                $new_jmb->management_id = $management->id;
                                                $new_jmb->date_formed = $jmb_date_formed;
                                                $new_jmb->certificate_no = $jmb_certificate_no;
                                                $new_jmb->name = $jmb_name;
                                                $new_jmb->address1 = '';
                                                $new_jmb->address2 = '';
                                                $new_jmb->address3 = '';
                                                $new_jmb->city = '';
                                                $new_jmb->poscode = '';
                                                $new_jmb->state = '';
                                                $new_jmb->country = '';
                                                $new_jmb->phone_no = '';
                                                $new_jmb->fax_no = '';
                                                $new_jmb->email = '';
                                                $new_jmb->save();
                                            }

                                            if ($is_mc) {
                                                $new_mc = new ManagementMC();
                                                $new_mc->file_id = $files->id;
                                                $new_mc->management_id = $management->id;
                                                $new_mc->date_formed = $mc_date_formed;
                                                $new_mc->first_agm = $mc_first_agm;
                                                $new_mc->name = $mc_name;
                                                $new_mc->address1 = '';
                                                $new_mc->address2 = '';
                                                $new_mc->address3 = '';
                                                $new_mc->city = '';
                                                $new_mc->poscode = '';
                                                $new_mc->state = '';
                                                $new_mc->country = '';
                                                $new_mc->phone_no = '';
                                                $new_mc->fax_no = '';
                                                $new_mc->email = '';
                                                $new_mc->save();
                                            }

                                            if ($is_agent) {
                                                $new_agent = new ManagementAgent();
                                                $new_agent->file_id = $files->id;
                                                $new_agent->management_id = $management->id;
                                                $new_agent->selected_by = $agent_selected_by;
                                                $new_agent->agent = $agent_name;
                                                $new_agent->address1 = '';
                                                $new_agent->address2 = '';
                                                $new_agent->address3 = '';
                                                $new_agent->city = '';
                                                $new_agent->poscode = '';
                                                $new_agent->state = '';
                                                $new_agent->country = '';
                                                $new_agent->phone_no = '';
                                                $new_agent->fax_no = '';
                                                $new_agent->email = '';
                                                $new_agent->save();
                                            }

                                            if ($is_others) {
                                                $new_others = new ManagementOthers();
                                                $new_others->file_id = $files->id;
                                                $new_others->management_id = $management->id;
                                                $new_others->name = $others_name;
                                                $new_others->address1 = '';
                                                $new_others->address2 = '';
                                                $new_others->address3 = '';
                                                $new_others->city = '';
                                                $new_others->poscode = '';
                                                $new_others->state = '';
                                                $new_others->country = '';
                                                $new_others->phone_no = '';
                                                $new_others->fax_no = '';
                                                $new_others->email = '';
                                                $new_others->save();
                                            }
                                        }

                                        $monitor = new Monitoring();
                                        $monitor->file_id = $files->id;
                                        $monitor->save();

                                        // Bulan Mula Laporan Kewangan
                                        // Nama
                                        $other_details_name = '';
                                        if (isset($row['61']) && !empty($row['61'])) {
                                            $other_details_name = trim($row['61']);
                                        }
                                        // Latitud
                                        $latitude = '';
                                        if (isset($row['62']) && !empty($row['62'])) {
                                            $latitude = trim($row['62']);
                                        }
                                        // Latitud
                                        $longitude = '';
                                        if (isset($row['63']) && !empty($row['63'])) {
                                            $longitude = trim($row['63']);
                                        }

                                        $others_details = new OtherDetails();
                                        $others_details->file_id = $files->id;
                                        $others_details->name = $other_details_name;
                                        $others_details->image_url = '';
                                        $others_details->latitude = $latitude;
                                        $others_details->longitude = $longitude;
                                        $others_details->description = '';
                                        $others_details->pms_system = '';
                                        $others_details->owner_occupied = '';
                                        $others_details->rented = '';
                                        $others_details->bantuan_lphs = '';
                                        $others_details->bantuan_others = '';
                                        $others_details->rsku = '';
                                        $others_details->water_meter = '';
                                        $others_details->malay_composition = '';
                                        $others_details->chinese_composition = '';
                                        $others_details->indian_composition = '';
                                        $others_details->others_composition = '';
                                        $others_details->foreigner_composition = '';
                                        $others_details->save();

                                        # Audit Trail
                                        $remarks = $files->file_no . ' has been imported.';
                                        $auditTrail = new AuditTrail();
                                        $auditTrail->module = "COB File";
                                        $auditTrail->remarks = $remarks;
                                        $auditTrail->audit_by = Auth::user()->id;
                                        $auditTrail->save();
                                    }
                                }
                            }
                        }
                    }

                    if (!empty($create_file)) {
                        print 'true';
                    } else {
                        print 'empty_data';
                    }
                } else {
                    print "empty_data";
                }
            } else {
                print "empty_file";
            }
        } else {
            print "false";
        }
    }

}
