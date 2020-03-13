<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

//change language
Route::get('/changeLanguage/{lang}', 'UserController@changeLanguage');

//company name
Route::post('/getCompanyName', 'HomeController@getCompanyName');

//login
Route::get('/', 'UserController@login')->before('guest');
Route::get('/login', 'UserController@login')->before('guest');
Route::post('/loginAction', 'UserController@loginAction')->before('guest');

//register
Route::get('/register', 'UserController@register')->before('guest');
Route::post('/submitRegister', 'UserController@submitRegister')->before('guest');

//change password
Route::get('/changePassword', 'UserController@changePassword')->before('authMember');
Route::post('/checkPasswordProfile', 'UserController@checkPasswordProfile')->before('authMember');
Route::post('/submitChangePassword', 'UserController@submitChangePassword')->before('authMember');

//edit profile
Route::get('/editProfile', 'UserController@editProfile')->before('authMember');
Route::post('/submitEditProfile', 'UserController@submitEditProfile')->before('authMember');

//logout
Route::get('/logout', 'UserController@logout')->before('authMember');

//home
Route::get('/home', 'AdminController@home')->before('authMember');
Route::get('/getAGMRemainder', 'AdminController@getAGMRemainder')->before('authMember');
Route::get('/getNeverAGM', 'AdminController@getNeverAGM')->before('authMember');
Route::get('/getAGM12Months', 'AdminController@getAGM12Months')->before('authMember');
Route::get('/getAGM15Months', 'AdminController@getAGM15Months')->before('authMember');
Route::get('/getMemoHome', 'AdminController@getMemoHome')->before('authMember');
Route::post('/getMemoDetails', 'AdminController@getMemoDetails')->before('authMember');

// --- COB Maintenance --- //
//file prefix
Route::get('/filePrefix', 'AdminController@filePrefix')->before('authMember');
Route::get('/addFilePrefix', 'AdminController@addFilePrefix')->before('authMember');
Route::post('/submitFilePrefix', 'AdminController@submitFilePrefix')->before('authMember');
Route::get('/getFilePrefix', 'AdminController@getFilePrefix')->before('authMember');
Route::post('/activeFilePrefix', 'AdminController@activeFilePrefix')->before('authMember');
Route::post('/inactiveFilePrefix', 'AdminController@inactiveFilePrefix')->before('authMember');
Route::get('/updateFilePrefix/{id}', 'AdminController@updateFilePrefix')->before('authMember');
Route::post('/submitUpdateFilePrefix', 'AdminController@submitUpdateFilePrefix')->before('authMember');
Route::post('/deleteFilePrefix/{id}', 'AdminController@deleteFilePrefix')->before('authMember');

//add file
Route::get('/addFile', 'AdminController@addFile')->before('authMember');
Route::post('/submitFile', 'AdminController@submitFile')->before('authMember');

// file list
Route::get('/fileList', 'AdminController@fileList')->before('authMember');
Route::get('/getFileList', 'AdminController@getFileList')->before('authMember');
Route::post('/activeFileList', 'AdminController@activeFileList')->before('authMember');
Route::post('/inactiveFileList', 'AdminController@inactiveFileList')->before('authMember');
Route::post('/deleteFileList', 'AdminController@deleteFileList')->before('authMember');

//house scheme
Route::get('/view/house/{id}', 'AdminController@viewHouse')->before('authMember');
Route::get('/update/house/{id}', 'AdminController@house')->before('authMember');
Route::post('/submitUpdateHouseScheme', 'AdminController@submitUpdateHouseScheme')->before('authMember');

//strata
Route::get('/view/strata/{id}', 'AdminController@viewStrata')->before('authMember');
Route::get('/update/strata/{id}', 'AdminController@strata')->before('authMember');
Route::post('/submitUpdateStrata', 'AdminController@submitUpdateStrata')->before('authMember');
Route::post('uploadStrataFile', 'FileController@uploadStrataFile');
Route::post('/findDUN', 'AdminController@findDUN')->before('authMember');
Route::post('/findPark', 'AdminController@findPark')->before('authMember');
Route::post('/deleteStrataFile/{id}', 'AdminController@deleteStrataFile')->before('authMember');

//management
Route::get('/view/management/{id}', 'AdminController@viewManagement')->before('authMember');
Route::get('/update/management/{id}', 'AdminController@management')->before('authMember');
Route::post('/submitUpdateManagement', 'AdminController@submitUpdateManagement')->before('authMember');
Route::post('/deleteAuditReport/{id}', 'AdminController@deleteAuditReport')->before('authMember');
Route::post('/deleteLetterIntegrity/{id}', 'AdminController@deleteLetterIntegrity')->before('authMember');
Route::post('/deleteLetterBankruptcy/{id}', 'AdminController@deleteLetterBankruptcy')->before('authMember');

//monitoring
Route::get('/view/monitoring/{id}', 'AdminController@viewMonitoring')->before('authMember');
Route::get('/update/monitoring/{id}', 'AdminController@monitoring')->before('authMember');
Route::post('/submitUpdateMonitoring', 'AdminController@submitUpdateMonitoring')->before('authMember');
Route::post('/addAGMDetails', 'AdminController@addAGMDetails')->before('authMember');
Route::post('/editAGMDetails', 'AdminController@editAGMDetails')->before('authMember');
Route::get('/getAGM/{file_id}', 'AdminController@getAGM')->before('authMember');
Route::post('/getAGMDetails', 'AdminController@getAGMDetails')->before('authMember');
Route::post('/deleteAGMDetails/{id}', 'AdminController@deleteAGMDetails')->before('authMember');
Route::post('/addAJKDetails', 'AdminController@addAJKDetails')->before('authMember');
Route::post('/editAJKDetails', 'AdminController@editAJKDetails')->before('authMember');
Route::get('/getAJK/{file_id}', 'AdminController@getAJK')->before('authMember');
Route::post('/deleteAJKDetails/{id}', 'AdminController@deleteAJKDetails')->before('authMember');
Route::get('/editAGM/{id}', 'AdminController@editAGM')->before('authMember');
Route::post('/uploadAuditReportFile', 'FileController@uploadAuditReportFile');
Route::post('/uploadAuditReportFileEdit', 'FileController@uploadAuditReportFileEdit');
Route::post('/uploadLetterIntegrity', 'FileController@uploadLetterIntegrity');
Route::post('/uploadLetterIntegrityEdit', 'FileController@uploadLetterIntegrityEdit');
Route::post('/uploadLetterBankruptcy', 'FileController@uploadLetterBankruptcy');
Route::post('/uploadLetterBankruptcyEdit', 'FileController@uploadLetterBankruptcyEdit');

//others
Route::get('/view/others/{id}', 'AdminController@viewOthers')->before('authMember');
Route::get('/updateFile/others/{id}', 'AdminController@others')->before('authMember');
Route::post('/submitUpdateOtherDetails', 'AdminController@submitUpdateOtherDetails')->before('authMember');
Route::post('/uploadOthersImage', 'ImageController@uploadOthersImage');
Route::post('/deleteImageOthers/{id}', 'AdminController@deleteImageOthers')->before('authMember');

//scoring
Route::get('/view/scoring/{id}', 'AdminController@viewScoring')->before('authMember');
Route::get('/update/scoring/{id}', 'AdminController@scoring')->before('authMember');
Route::post('/addScoring', 'AdminController@addScoring')->before('authMember');
Route::post('/editScoring', 'AdminController@editScoring')->before('authMember');
Route::get('/getScoring/{id}', 'AdminController@getScoring')->before('authMember');
Route::post('/deleteScoring/{id}', 'AdminController@deleteScoring')->before('authMember');

//buyer
Route::get('/view/buyer/{id}', 'AdminController@viewBuyer')->before('authMember');
Route::get('/update/buyer/{id}', 'AdminController@buyer')->before('authMember');
Route::get('/update/addBuyer/{id}', 'AdminController@addBuyer')->before('authMember');
Route::get('/update/editBuyer/{id}', 'AdminController@editBuyer')->before('authMember');
Route::post('/submitBuyer', 'AdminController@submitBuyer')->before('authMember');
Route::post('/submitEditBuyer', 'AdminController@submitEditBuyer')->before('authMember');
Route::get('/getBuyerList/{id}', 'AdminController@getBuyerList')->before('authMember');
Route::post('/deleteBuyer', 'AdminController@deleteBuyer')->before('authMember');

//upload csv
Route::get('/update/importBuyer/{id}', 'AdminController@importBuyer')->before('authMember');
Route::post('/uploadBuyerCSVAction/{id}', 'FileController@uploadBuyerCSVAction')->before('authMember');
Route::post('/submitUploadBuyer/{id}', 'AdminController@submitUploadBuyer')->before('authMember');

//file approval
Route::get('/approval/{id}', 'AdminController@fileApproval')->before('authMember');
Route::post('/submitApproval', 'AdminController@submitFileApproval')->before('authMember');

// --- Administration --- //
//edit company
Route::get('/editCompany', 'AdminController@editCompany')->before('authMember');
Route::post('/submitEditCompany', 'AdminController@submitEditCompany')->before('authMember');

//upload logo
Route::post('/logoImage', 'ImageController@logoImage');

//upload nav image
Route::post('/navbarImage', 'ImageController@navbarImage');

//access group
Route::get('/accessGroups', 'AdminController@accessGroups')->before('authMember');
Route::get('/addAccessGroup', 'AdminController@addAccessGroup')->before('authMember');
Route::post('/submitAccessGroup', 'AdminController@submitAccessGroup')->before('authMember');
Route::get('/getAccessGroups', 'AdminController@getAccessGroups')->before('authMember');
Route::post('/activeAccessGroup', 'AdminController@activeAccessGroup')->before('authMember');
Route::post('/inactiveAccessGroup', 'AdminController@inactiveAccessGroup')->before('authMember');
Route::get('/updateAccessGroup/{id}', 'AdminController@updateAccessGroup')->before('authMember');
Route::post('/submitUpdateAccessGroup', 'AdminController@submitUpdateAccessGroup')->before('authMember');
Route::post('/deleteAccessGroup/{id}', 'AdminController@deleteAccessGroup')->before('authMember');

//user
Route::get('/user', 'AdminController@user')->before('authMember');
Route::get('/addUser', 'AdminController@addUser')->before('authMember');
Route::post('/submitUser', 'AdminController@submitUser')->before('authMember');
Route::get('/getUser', 'AdminController@getUser')->before('authMember');
Route::get('/getUserDetails/{id}', 'AdminController@getUserDetails')->before('authMember');
Route::post('/submitApprovedUser', 'AdminController@submitApprovedUser')->before('authMember');
Route::post('/activeUser', 'AdminController@activeUser')->before('authMember');
Route::post('/inactiveUser', 'AdminController@inactiveUser')->before('authMember');
Route::get('/updateUser/{id}', 'AdminController@updateUser')->before('authMember');
Route::post('/submitUpdateUser', 'AdminController@submitUpdateUser')->before('authMember');
Route::post('/deleteUser/{id}', 'AdminController@deleteUser')->before('authMember');

//memo
Route::get('/memo', 'AdminController@memo')->before('authMember');
Route::get('/addMemo', 'AdminController@addMemo')->before('authMember');
Route::post('/submitMemo', 'AdminController@submitMemo')->before('authMember');
Route::get('/getMemo', 'AdminController@getMemo')->before('authMember');
Route::post('/activeMemo', 'AdminController@activeMemo')->before('authMember');
Route::post('/inactiveMemo', 'AdminController@inactiveMemo')->before('authMember');
Route::get('/updateMemo/{id}', 'AdminController@updateMemo')->before('authMember');
Route::post('/submitUpdateMemo', 'AdminController@submitUpdateMemo')->before('authMember');
Route::post('/deleteMemo/{id}', 'AdminController@deleteMemo')->before('authMember');

//form
Route::get('/form', 'AdminController@form')->before('authMember');
Route::get('/addForm', 'AdminController@addForm')->before('authMember');
Route::post('/submitForm', 'AdminController@submitForm')->before('authMember');
Route::get('/getForm', 'AdminController@getForm')->before('authMember');
Route::post('/activeForm', 'AdminController@activeForm')->before('authMember');
Route::post('/inactiveForm', 'AdminController@inactiveForm')->before('authMember');
Route::get('/updateForm/{id}', 'AdminController@updateForm')->before('authMember');
Route::post('/submitUpdateForm', 'AdminController@submitUpdateForm')->before('authMember');
Route::post('/deleteForm/{id}', 'AdminController@deleteForm')->before('authMember');

########################## AGM Submission
//AGM Design Submission
Route::get('/AJK','AgmController@AJK')->before('authMember');
Route::get('/getAJK','AgmController@getAJK')->before('authMember');
Route::post('/addAJK','AgmController@addAJK')->before('authMember');
Route::post('/editAJK','AgmController@editAJK')->before('authMember');
Route::post('/deleteAJK','AgmController@deleteAJK')->before('authMember');


/*
 * RONALDO
 */
Route::get('/agmDesignSub','AgmController@agmDesignSub')->before('authMember');
Route::get('/addAgmDesignSub', 'AgmController@addAgmDesignSub')->before('authMember');
Route::post('/submitAgmDesignSub', 'AgmController@submitAgmDesignSub')->before('authMember');
Route::get('/getAgmDesignSub', 'AgmController@getAgmDesignSub')->before('authMember');
Route::post('/activeAgmDesignSub', 'AgmController@activeAgmDesignSub')->before('authMember');
Route::post('/inactiveAgmDesignSub', 'AgmController@inactiveAgmDesignSub')->before('authMember');
Route::get('/updateAgmDesignSub/{id}', 'AgmController@updateAgmDesignSub')->before('authMember');
Route::post('/submitUpdateAgmDesignSub', 'AgmController@submitUpdateAgmDesignSub')->before('authMember');
Route::post('/deleteAgmDesignSub/{id}', 'AgmController@deleteAgmDesignSub')->before('authMember');

//AGM Purchase Sub
Route::get('/agmPurchaseSub', 'AgmController@agmPurchaseSub')->before('authMember');
Route::get('/addAgmPurchaseSub', 'AgmController@addAgmPurchaseSub')->before('authMember');
Route::post('/submitAgmPurchaseSub', 'AgmController@submitAgmPurchaseSub')->before('authMember');
Route::get('/getAgmPurchaseSub', 'AgmController@getAgmPurchaseSub')->before('authMember');
Route::post('/activeAgmPurchaseSub', 'AgmController@activeAgmPurchaseSub')->before('authMember');
Route::post('/inactiveAgmPurchaseSub', 'AgmController@inactiveAgmPurchaseSub')->before('authMember');
Route::get('/updateAgmPurchaseSub/{id}', 'AgmController@updateAgmPurchaseSub')->before('authMember');
Route::post('/submitUpdateAgmPurchaseSub', 'AgmController@submitUpdateAgmPurchaseSub')->before('authMember');
Route::post('/deleteAgmPurchaseSub/{id}', 'AgmController@deleteAgmPurchaseSub')->before('authMember');

// Report LHPS
Route::get('/lhpsReportStrata', 'ReportController@reportStrataProfile')->before('authMember');
Route::get('/submitLhpsReportStrata', 'ReportController@submitLhpsReportStrata')->before('authMember');

// --- Master Setup --- //
//area
Route::get('/area', 'AdminController@area')->before('authMember');
Route::get('/addArea', 'AdminController@addArea')->before('authMember');
Route::post('/submitArea', 'AdminController@submitArea')->before('authMember');
Route::get('/getArea', 'AdminController@getArea')->before('authMember');
Route::post('/activeArea', 'AdminController@activeArea')->before('authMember');
Route::post('/inactiveArea', 'AdminController@inactiveArea')->before('authMember');
Route::get('/updateArea/{id}', 'AdminController@updateArea')->before('authMember');
Route::post('/submitUpdateArea', 'AdminController@submitUpdateArea')->before('authMember');
Route::post('/deleteArea/{id}', 'AdminController@deleteArea')->before('authMember');

//city
Route::get('/city', 'AdminController@city')->before('authMember');
Route::get('/addCity', 'AdminController@addCity')->before('authMember');
Route::post('/submitCity', 'AdminController@submitCity')->before('authMember');
Route::get('/getCity', 'AdminController@getCity')->before('authMember');
Route::post('/activeCity', 'AdminController@activeCity')->before('authMember');
Route::post('/inactiveCity', 'AdminController@inactiveCity')->before('authMember');
Route::get('/updateCity/{id}', 'AdminController@updateCity')->before('authMember');
Route::post('/submitUpdateCity', 'AdminController@submitUpdateCity')->before('authMember');
Route::post('/deleteCity/{id}', 'AdminController@deleteCity')->before('authMember');

//country
Route::get('/country', 'AdminController@country')->before('authMember');
Route::get('/addCountry', 'AdminController@addCountry')->before('authMember');
Route::post('/submitCountry', 'AdminController@submitCountry')->before('authMember');
Route::get('/getCountry', 'AdminController@getCountry')->before('authMember');
Route::post('/activeCountry', 'AdminController@activeCountry')->before('authMember');
Route::post('/inactiveCountry', 'AdminController@inactiveCountry')->before('authMember');
Route::get('/updateCountry/{id}', 'AdminController@updateCountry')->before('authMember');
Route::post('/submitUpdateCountry', 'AdminController@submitUpdateCountry')->before('authMember');
Route::post('/deleteCountry/{id}', 'AdminController@deleteCountry')->before('authMember');

//language
Route::get('/language', 'AdminController@language')->before('authMember');
Route::get('/addLanguage', 'AdminController@addLanguage')->before('authMember');
Route::post('/submitLanguage', 'AdminController@submitLanguage')->before('authMember');
Route::get('/getLanguage', 'AdminController@getLanguage')->before('authMember');
Route::post('/activeLanguage', 'AdminController@activeLanguage')->before('authMember');
Route::post('/inactiveLanguage', 'AdminController@inactiveLanguage')->before('authMember');
Route::get('/updateLanguage/{id}', 'AdminController@updateLanguage')->before('authMember');
Route::post('/submitUpdateLanguage', 'AdminController@submitUpdateLanguage')->before('authMember');
Route::post('/deleteLanguage/{id}', 'AdminController@deleteLanguage')->before('authMember');

//state
Route::get('/state', 'AdminController@state')->before('authMember');
Route::get('/addState', 'AdminController@addState')->before('authMember');
Route::post('/submitState', 'AdminController@submitState')->before('authMember');
Route::get('/getState', 'AdminController@getState')->before('authMember');
Route::post('/activeState', 'AdminController@activeState')->before('authMember');
Route::post('/inactiveState', 'AdminController@inactiveState')->before('authMember');
Route::get('/updateState/{id}', 'AdminController@updateState')->before('authMember');
Route::post('/submitUpdateState', 'AdminController@submitUpdateState')->before('authMember');
Route::post('/deleteState/{id}', 'AdminController@deleteState')->before('authMember');


//Document Type
Route::get('/documenttype', 'AdminController@documenttype')->before('authMember');
Route::get('/addDocumenttype', 'AdminController@addDocumenttype')->before('authMember');
Route::post('/submitDocumenttype', 'AdminController@submitDocumenttype')->before('authMember');
Route::get('/getDocumenttype', 'AdminController@getDocumenttype')->before('authMember');
Route::post('/activeDocumenttype', 'AdminController@activeDocumenttype')->before('authMember');
Route::post('/inactiveDocumenttype', 'AdminController@inactiveDocumenttype')->before('authMember');
Route::get('/updateDocumenttype/{id}', 'AdminController@updateDocumenttype')->before('authMember');
Route::post('/submitUpdateDocumenttype', 'AdminController@submitUpdateDocumenttype')->before('authMember');
Route::post('/deleteDocumenttype/{id}', 'AdminController@deleteDocumenttype')->before('authMember');

//Form Type
Route::get('/formtype', 'AdminController@formtype')->before('authMember');
Route::get('/addFormtype', 'AdminController@addFormtype')->before('authMember');
Route::post('/submitFormtype', 'AdminController@submitFormtype')->before('authMember');
Route::get('/getFormtype', 'AdminController@getFormtype')->before('authMember');
Route::post('/activeFormtype', 'AdminController@activeFormtype')->before('authMember');
Route::post('/inactiveFormtype', 'AdminController@inactiveFormtype')->before('authMember');
Route::get('/updateFormtype/{id}', 'AdminController@updateFormtype')->before('authMember');
Route::post('/submitUpdateFormtype', 'AdminController@submitUpdateFormtype')->before('authMember');
Route::post('/deleteFormtype/{id}', 'AdminController@deleteFormtype')->before('authMember');

//category
Route::get('/category', 'AdminController@category')->before('authMember');
Route::get('/addCategory', 'AdminController@addCategory')->before('authMember');
Route::post('/submitCategory', 'AdminController@submitCategory')->before('authMember');
Route::get('/getCategory', 'AdminController@getCategory')->before('authMember');
Route::post('/activeCategory', 'AdminController@activeCategory')->before('authMember');
Route::post('/inactiveCategory', 'AdminController@inactiveCategory')->before('authMember');
Route::get('/updateCategory/{id}', 'AdminController@updateCategory')->before('authMember');
Route::post('/submitUpdateCategory', 'AdminController@submitUpdateCategory')->before('authMember');
Route::post('/deleteCategory/{id}', 'AdminController@deleteCategory')->before('authMember');

//land
Route::get('/landTitle', 'AdminController@landTitle')->before('authMember');
Route::get('/addLandTitle', 'AdminController@addLandTitle')->before('authMember');
Route::post('/submitLandTitle', 'AdminController@submitLandTitle')->before('authMember');
Route::get('/getLandTitle', 'AdminController@getLandTitle')->before('authMember');
Route::post('/activeLandTitle', 'AdminController@activeLandTitle')->before('authMember');
Route::post('/inactiveLandTitle', 'AdminController@inactiveLandTitle')->before('authMember');
Route::get('/updateLandTitle/{id}', 'AdminController@updateLandTitle')->before('authMember');
Route::post('/submitUpdateLandTitle', 'AdminController@submitUpdateLandTitle')->before('authMember');
Route::post('/deleteLandTitle/{id}', 'AdminController@deleteLandTitle')->before('authMember');

//developer
Route::get('/developer', 'AdminController@developer')->before('authMember');
Route::get('/addDeveloper', 'AdminController@addDeveloper')->before('authMember');
Route::post('/submitDeveloper', 'AdminController@submitDeveloper')->before('authMember');
Route::get('/getDeveloper', 'AdminController@getDeveloper')->before('authMember');
Route::post('/activeDeveloper', 'AdminController@activeDeveloper')->before('authMember');
Route::post('/inactiveDeveloper', 'AdminController@inactiveDeveloper')->before('authMember');
Route::get('/updateDeveloper/{id}', 'AdminController@updateDeveloper')->before('authMember');
Route::post('/submitUpdateDeveloper', 'AdminController@submitUpdateDeveloper')->before('authMember');
Route::post('/deleteDeveloper/{id}', 'AdminController@deleteDeveloper')->before('authMember');

//developer
Route::get('/agent', 'AdminController@agent')->before('authMember');
Route::get('/addAgent', 'AdminController@addAgent')->before('authMember');
Route::post('/submitAgent', 'AdminController@submitAgent')->before('authMember');
Route::get('/getAgent', 'AdminController@getAgent')->before('authMember');
Route::post('/activeAgent', 'AdminController@activeAgent')->before('authMember');
Route::post('/inactiveAgent', 'AdminController@inactiveAgent')->before('authMember');
Route::get('/updateAgent/{id}', 'AdminController@updateAgent')->before('authMember');
Route::post('/submitUpdateAgent', 'AdminController@submitUpdateAgent')->before('authMember');
Route::post('/deleteAgent/{id}', 'AdminController@deleteAgent')->before('authMember');

//parliment
Route::get('/parliment', 'AdminController@parliment')->before('authMember');
Route::get('/addParliment', 'AdminController@addParliment')->before('authMember');
Route::post('/submitParliment', 'AdminController@submitParliment')->before('authMember');
Route::get('/getParliment', 'AdminController@getParliment')->before('authMember');
Route::post('/activeParliment', 'AdminController@activeParliment')->before('authMemberauthMember');
Route::post('/inactiveParliment', 'AdminController@inactiveParliment')->before('authMember');
Route::get('/updateParliment/{id}', 'AdminController@updateParliment')->before('authMember');
Route::post('/submitUpdateParliment', 'AdminController@submitUpdateParliment')->before('authMember');
Route::post('/deleteParliment/{id}', 'AdminController@deleteParliment')->before('authMember');

//DUN
Route::get('/DUN', 'AdminController@dun')->before('authMember');
Route::get('/addDUN', 'AdminController@addDun')->before('authMember');
Route::post('/submitDUN', 'AdminController@submitDun')->before('authMember');
Route::get('/getDUN', 'AdminController@getDun')->before('authMember');
Route::post('/activeDUN', 'AdminController@activeDun')->before('authMember');
Route::post('/inactiveDUN', 'AdminController@inactiveDun')->before('authMember');
Route::get('/updateDUN/{id}', 'AdminController@updateDun')->before('authMember');
Route::post('/submitUpdateDUN', 'AdminController@submitUpdateDun')->before('authMember');
Route::post('/deleteDUN/{id}', 'AdminController@deleteDun')->before('authMember');

//Park
Route::get('/park', 'AdminController@park')->before('authMember');
Route::get('/addPark', 'AdminController@addPark')->before('authMember');
Route::post('/submitPark', 'AdminController@submitPark')->before('authMember');
Route::get('/getPark', 'AdminController@getPark')->before('authMember');
Route::post('/activePark', 'AdminController@activePark')->before('authMember');
Route::post('/inactivePark', 'AdminController@inactivePark')->before('authMemberauthMember');
Route::get('/updatePark/{id}', 'AdminController@updatePark')->before('authMember');
Route::post('/submitUpdatePark', 'AdminController@submitUpdatePark')->before('authMember');
Route::post('/deletePark/{id}', 'AdminController@deletePark')->before('authMember');

//memo type
Route::get('/memoType', 'AdminController@memoType')->before('authMember');
Route::get('/addMemoType', 'AdminController@addMemoType')->before('authMember');
Route::post('/submitMemoType', 'AdminController@submitMemoType')->before('authMember');
Route::get('/getMemoType', 'AdminController@getMemoType')->before('authMember');
Route::post('/activeMemoType', 'AdminController@activeMemoType')->before('authMember');
Route::post('/inactiveMemoType', 'AdminController@inactiveMemoType')->before('authMember');
Route::get('/updateMemoType/{id}', 'AdminController@updateMemoType')->before('authMemberauthMember');
Route::post('/submitUpdateMemoType', 'AdminController@submitUpdateMemoType')->before('authMember');
Route::post('/deleteMemoType/{id}', 'AdminController@deleteMemoType')->before('authMember');

//designation
Route::get('/designation', 'AdminController@designation')->before('authMember');
Route::get('/addDesignation', 'AdminController@addDesignation')->before('authMember');
Route::post('/submitDesignation', 'AdminController@submitDesignation')->before('authMember');
Route::get('/getDesignation', 'AdminController@getDesignation')->before('authMember');
Route::post('/activeDesignation', 'AdminController@activeDesignation')->before('authMember');
Route::post('/inactiveDesignation', 'AdminController@inactiveDesignation')->before('authMember');
Route::get('/updateDesignation/{id}', 'AdminController@updateDesignation')->before('authMember');
Route::post('/submitUpdateDesignation', 'AdminController@submitUpdateDesignation')->before('authMember');
Route::post('/deleteDesignation/{id}', 'AdminController@deleteDesignation')->before('authMember');

//unit measure
Route::get('/unitMeasure', 'AdminController@unitMeasure')->before('authMember');
Route::get('/addUnitMeasure', 'AdminController@addUnitMeasure')->before('authMember');
Route::post('/submitUnitMeasure', 'AdminController@submitUnitMeasure')->before('authMember');
Route::get('/getUnitMeasure', 'AdminController@getUnitMeasure')->before('authMember');
Route::post('/activeUnitMeasure', 'AdminController@activeUnitMeasure')->before('authMember');
Route::post('/inactiveUnitMeasure', 'AdminController@inactiveUnitMeasure')->before('authMember');
Route::get('/updateUnitMeasure/{id}', 'AdminController@updateUnitMeasure')->before('authMember');
Route::post('/submitUpdateUnitMeasure', 'AdminController@submitUpdateUnitMeasure')->before('authMember');
Route::post('/deleteUnitMeasure/{id}', 'AdminController@deleteUnitMeasure')->before('authMember');

// FINANCE FILE LIST
Route::get('/financeList', 'AdminController@financeList')->before('authMember');
Route::get('/getFinanceList', 'AdminController@getFinanceList')->before('authMember');
Route::post('/inactiveFinanceList', 'AdminController@inactiveFinanceList')->before('authMember');
Route::post('/activeFinanceList', 'AdminController@activeFinanceList')->before('authMember');
Route::post('/deleteFinanceList', 'AdminController@deleteFinanceList')->before('authMember');

Route::get('/addFinanceFileList', 'AdminController@addFinanceFileList')->before('authMember');
Route::post('/submitFinanceFile', 'AdminController@submitFinanceFile')->before('authMember');
Route::get('/editFinanceFileList/{id}', 'AdminController@editFinanceFileList')->before('authMember');
Route::post('/updateFinanceFileList', 'AdminController@updateFinanceFileList')->before('authMember');

Route::post('/updateFinanceCheck','FinanceController@updateFinanceCheck' )->before('authMember');
Route::post('/updateFinanceFileAdmin','FinanceController@updateFinanceFileAdmin' )->before('authMember');
Route::post('/updateFinanceFileStaff','FinanceController@updateFinanceFileStaff' )->before('authMember');
Route::post('/updateFinanceFileContract','FinanceController@updateFinanceFileContract' )->before('authMember');
Route::post('/updateFinanceFileVandal','FinanceController@updateFinanceFileVandal' )->before('authMember');
Route::post('/updateFinanceFileRepair','FinanceController@updateFinanceFileRepair' )->before('authMember');
Route::post('/updateFinanceFileIncome','FinanceController@updateFinanceFileIncome' )->before('authMember');
Route::post('/updateFinanceFileUtility','FinanceController@updateFinanceFileUtility' )->before('authMember');
Route::post('/updateFinanceFileReportSf', 'FinanceController@updateFinanceFileReportSf')->before('authMember');
Route::post('/updateFinanceFileReportMf', 'FinanceController@updateFinanceFileReportMf')->before('authMember');

// FINANCE SUPPORT
Route::get('/financeSupport', 'AdminController@financeSupport')->before('authMember');
Route::get('/getFinanceSupportList', 'AdminController@getFinanceSupportList')->before('authMember');
Route::get('/addFinanceSupport', 'AdminController@addFinanceSupport')->before('authMember');
Route::post('/submitFinanceSupport', 'AdminController@submitFinanceSupport')->before('authMember');
Route::get('/editFinanceSupport/{id}', 'AdminController@editFinanceSupport')->before('authMember');
Route::post('/updateFinanceSupport', 'AdminController@updateFinanceSupport')->before('authMember');

// --- Reporting --- //
//audit trail
Route::get('/reporting/auditTrail', 'AdminController@auditTrail')->before('authMember');
Route::get('/getAuditTrail', 'AdminController@getAuditTrail')->before('authMember');

//file by location
Route::get('/reporting/fileByLocation', 'AdminController@fileByLocation')->before('authMember');
Route::get('/getFileByLocation', 'AdminController@getFileByLocation')->before('authMember');

//rating summary
Route::get('/reporting/ratingSummary', 'AdminController@ratingSummary')->before('authMember');

//management summary
Route::get('/reporting/managementSummary', 'AdminController@managementSummary')->before('authMember');

//cob file / management
Route::get('/reporting/cobFileManagement', 'AdminController@cobFileManagement')->before('authMember');

// -- COB -- //
Route::get('cob/get/{id}', 'CobController@get');
Route::get('cob/{id}/get-data', 'CobController@getData');
Route::get('cob/add/{id}', 'CobController@add');
Route::post('cob/store', 'CobController@store');
Route::get('cob/edit/{id}', 'CobController@edit');
Route::post('cob/update', 'CobController@update');

// --- Printing --- //
//audit trail
Route::get('/print/AuditTrail', 'PrintController@printAuditTrail')->before('authMember');

//file by location
Route::get('/print/FileByLocation', 'PrintController@printFileByLocation')->before('authMember');

//rating summary
Route::get('/print/RatingSummary', 'PrintController@printRatingSummary')->before('authMember');

//management summary
Route::get('/print/ManagementSummary', 'PrintController@printManagementSummary')->before('authMember');

//cob file / management
Route::get('/print/CobFileManagement', 'PrintController@printCobFileManagement')->before('authMember');

//invalid route
Route::get('/{name?}','AdminController@showView')->before('authMember');
