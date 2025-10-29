@extends('layouts.app')

@section('title', 'Users List')

@section('content')
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.min.css">
<script src="https://cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>


<div class="nftmax-table mg-top-40">
<div class="panel-body table-responsive">
<div class="panel-body table-responsive">
            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper no-footer"><div class="dataTables_length" id="DataTables_Table_0_length"><label>Show <select name="DataTables_Table_0_length" aria-controls="DataTables_Table_0" class=""><option value="10">10</option><option value="25">25</option><option value="50">50</option><option value="100">100</option></select> entries</label></div><div class="dt-buttons"><a class="dt-button buttons-copy buttons-html5" tabindex="0" aria-controls="DataTables_Table_0" href="#"><span>Copy</span></a><a class="dt-button buttons-csv buttons-html5" tabindex="0" aria-controls="DataTables_Table_0" href="#"><span>CSV</span></a><a class="dt-button buttons-excel buttons-html5" tabindex="0" aria-controls="DataTables_Table_0" href="#"><span>Excel</span></a><a class="dt-button buttons-pdf buttons-html5" tabindex="0" aria-controls="DataTables_Table_0" href="#"><span>PDF</span></a><a class="dt-button buttons-print" tabindex="0" aria-controls="DataTables_Table_0" href="#"><span>Print</span></a><a class="dt-button buttons-collection buttons-colvis" tabindex="0" aria-controls="DataTables_Table_0" href="#"><span>Column visibility</span></a></div><div id="DataTables_Table_0_filter" class="dataTables_filter"><label>Search:<input type="search" class="" placeholder="" aria-controls="DataTables_Table_0"></label></div><table class="table table-bordered table-striped datatable dataTable no-footer" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
                <thead>
                    <tr role="row"><th style="text-align:center;" class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="S.no.: activate to sort column ascending">S.no.</th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label=" Category : activate to sort column ascending" style="width: 275px;"> Category </th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label=" Status : activate to sort column ascending" style="width: 163px;"> Status </th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="&amp;nbsp;: activate to sort column ascending" style="width: 325px;">&nbsp;</th></tr>
                </thead>
                
                <tbody>
                                                                                                                    
                                                                            
                                                                            
                                                            <tr data-entry-id="1" role="row" class="odd">
                                
                               <td style="text-align:center;">1</td>

                                <td field-key="title">Sample category</td>

                                 <td field-key="title">Active</td>


                                    <td>
                                                                        <a href="https://onlineauctionscript.digisamaritan.com/faq_categories/view/sample-category-a797ef10865664bf24c9f65ef1a9dbbdaed20e33" class="btn btn-xs btn-primary"> View </a>
                                                                                                            <a href="https://onlineauctionscript.digisamaritan.com/faq_categories/edit/sample-category-a797ef10865664bf24c9f65ef1a9dbbdaed20e33" class="btn btn-xs btn-info"> Edit </a>
                                                                                                            <a class="btn btn-xs btn-danger" href="javascript:void(0)" onclick="deleteRecord('1')"> Delete </a>
                                                                    </td>

                            </tr><tr data-entry-id="3" role="row" class="even">
                                
                               <td style="text-align:center;">2</td>

                                <td field-key="title">Registration</td>

                                 <td field-key="title">Active</td>


                                    <td>
                                                                        <a href="https://onlineauctionscript.digisamaritan.com/faq_categories/view/registration-77c63d143f24a4fc02c64a00ed90263b63d8e419-1" class="btn btn-xs btn-primary"> View </a>
                                                                                                            <a href="https://onlineauctionscript.digisamaritan.com/faq_categories/edit/registration-77c63d143f24a4fc02c64a00ed90263b63d8e419-1" class="btn btn-xs btn-info"> Edit </a>
                                                                                                            <a class="btn btn-xs btn-danger" href="javascript:void(0)" onclick="deleteRecord('3')"> Delete </a>
                                                                    </td>

                            </tr><tr data-entry-id="4" role="row" class="odd">
                                
                               <td style="text-align:center;">3</td>

                                <td field-key="title">Auction</td>

                                 <td field-key="title">Active</td>


                                    <td>
                                                                        <a href="https://onlineauctionscript.digisamaritan.com/faq_categories/view/auction-b7441ded89c4e2989e80fb62454c69c5dd8e7238-2" class="btn btn-xs btn-primary"> View </a>
                                                                                                            <a href="https://onlineauctionscript.digisamaritan.com/faq_categories/edit/auction-b7441ded89c4e2989e80fb62454c69c5dd8e7238-2" class="btn btn-xs btn-info"> Edit </a>
                                                                                                            <a class="btn btn-xs btn-danger" href="javascript:void(0)" onclick="deleteRecord('4')"> Delete </a>
                                                                    </td>

                            </tr></tbody>
            </table><div class="dataTables_info" id="DataTables_Table_0_info" role="status" aria-live="polite">Showing 1 to 3 of 3 entries</div><div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_0_paginate"><a class="paginate_button previous disabled" aria-controls="DataTables_Table_0" data-dt-idx="0" tabindex="0" id="DataTables_Table_0_previous">Previous</a><span><a class="paginate_button current" aria-controls="DataTables_Table_0" data-dt-idx="1" tabindex="0">1</a></span><a class="paginate_button next disabled" aria-controls="DataTables_Table_0" data-dt-idx="2" tabindex="0" id="DataTables_Table_0_next">Next</a></div><div class="actions"></div></div>
        </div>                <thead>
                    <tr role="row"><th style="text-align:center;" class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="S.no.: activate to sort column ascending">S.no.</th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label=" Image : activate to sort column ascending" style="width: 38px;"> Image </th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label=" Title : activate to sort column ascending" style="width: 132px;"> Title </th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label=" Start Date : activate to sort column ascending" style="width: 39px;"> Start Date </th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label=" End Date : activate to sort column ascending" style="width: 39px;"> End Date </th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label=" Reserve Price ($) : activate to sort column ascending" style="width: 61px;"> Reserve Price ($) </th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label=" Seller : activate to sort column ascending" style="width: 36px;"> Seller </th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label=" Created By : activate to sort column ascending" style="width: 50px;"> Created By </th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label=" Auction Status : activate to sort column ascending" style="width: 51px;"> Auction Status </th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label=" Admin Status : activate to sort column ascending" style="width: 44px;"> Admin Status </th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label=" Live Auction : activate to sort column ascending" style="width: 59px;"> Live Auction </th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="&amp;nbsp;: activate to sort column ascending" style="width: 23px;">&nbsp;</th></tr>
                </thead>
                                <tbody>
                                                                                                                      
                                                                             
                                                                             
                                                                             
                                                                             
                                                                             
                                                                             
                                                                             
                                                                             
                                                                             
                                                                             
                                                                             
                                                                             
                                                                             
                                                                             
                                                                             
                                                                             
                                                                             
                                                                             
                                                                             
                                                                             
                                                                             
                                                                             
                                                                             
                                                                             
                                                                             
                                                                             
                                                                             
                                                            <tr data-entry-id="29" role="row" class="odd">
                              
                                <td style="text-align:center;">1</td>
                     
                                <td field-key="image"> <a href="https://onlineauctionscript.digisamaritan.com/public/uploads/auctions/_S6Io1Xw7fUoFo49.png" target="_blank"><img src="https://onlineauctionscript.digisamaritan.com/public/uploads/auctions/thumbnail/_S6Io1Xw7fUoFo49.png" alt="testaaa" width="50"> </a> </td>

                                <td> testaaa </td>

                                <td>  2024-09-30 10:14:00  </td>

                                <td>   2024-09-30 19:15:00  </td>

                                <td>200.00</td>
                                                                <td> <a href="https://onlineauctionscript.digisamaritan.com/users/view/seller-1" target="_blank" title="Seller Details"> seller</a></td>
                                                                <td>admin</td>

                                <td>open</td>

                                <td>approved</td>

                                <td>  

                                    2024-09-30 
                                    (
                                                                            07:14:37
                                    
                                    -

                                                                            22:14:40
                                                                        )
                                     </td>

                                <td>
                                    
                                    <a href="https://onlineauctionscript.digisamaritan.com/auctions/view/test-84b690a7990d6cfc7d73356fd1f1983974ae4149-27" class="btn btn-xs btn-primary"> View </a>
                                   
                                    <a href="https://onlineauctionscript.digisamaritan.com/auctions/edit/test-84b690a7990d6cfc7d73356fd1f1983974ae4149-27" class="btn btn-xs btn-info"> Edit </a>
                                    
                                </td>


                            </tr><tr data-entry-id="28" role="row" class="even">
                              
                                <td style="text-align:center;">2</td>
                     
                                <td field-key="image"> <a href="https://onlineauctionscript.digisamaritan.com/public/uploads/auctions/28_rpgfovxF1a4rKMm.jpg" target="_blank"><img src="https://onlineauctionscript.digisamaritan.com/public/uploads/auctions/thumbnail/28_rpgfovxF1a4rKMm.jpg" alt="art 2" width="50"> </a> </td>

                                <td> art 2 </td>

                                <td>  2024-09-30 22:58:00  </td>

                                <td>   2024-09-30 22:59:00  </td>

                                <td>1200.00</td>
                                                                <td> <a href="https://onlineauctionscript.digisamaritan.com/users/view/seller-1" target="_blank" title="Seller Details"> seller</a></td>
                                                                <td>admin</td>

                                <td>closed</td>

                                <td>approved</td>

                                <td>  

                                    2024-09-30 
                                    (
                                                                            12:58:46
                                    
                                    -

                                                                            21:58:56
                                                                        )
                                     </td>

                                <td>
                                    
                                    <a href="https://onlineauctionscript.digisamaritan.com/auctions/view/art-2-f2966773888d7b7b6ad6ad313d7968da823adb67-26" class="btn btn-xs btn-primary"> View </a>
                                   
                                    <a href="https://onlineauctionscript.digisamaritan.com/auctions/edit/art-2-f2966773888d7b7b6ad6ad313d7968da823adb67-26" class="btn btn-xs btn-info"> Edit </a>
                                    
                                </td>


                            </tr><tr data-entry-id="27" role="row" class="odd">
                              
                                <td style="text-align:center;">3</td>
                     
                                <td field-key="image"> <a href="https://onlineauctionscript.digisamaritan.com/public/uploads/auctions/_SgRf7TP1i5BWgyV.jpg" target="_blank"><img src="https://onlineauctionscript.digisamaritan.com/public/uploads/auctions/thumbnail/_SgRf7TP1i5BWgyV.jpg" alt="Butterfly Art" width="50"> </a> </td>

                                <td> Butterfly Art </td>

                                <td>  2024-09-24 13:12:00  </td>

                                <td>   2024-10-31 13:13:00  </td>

                                <td>700.00</td>
                                                                <td> <a href="https://onlineauctionscript.digisamaritan.com/users/view/seller-1" target="_blank" title="Seller Details"> seller</a></td>
                                                                <td>seller</td>

                                <td>open</td>

                                <td>approved</td>

                                <td>  

                                    2024-09-30 
                                    (
                                                                            10:13:03
                                    
                                    -

                                                                            20:13:10
                                                                        )
                                     </td>

                                <td>
                                    
                                    <a href="https://onlineauctionscript.digisamaritan.com/auctions/view/butterfly-art-a1bb22cc237dae8603624090a38788c5ea2dc1b3-25" class="btn btn-xs btn-primary"> View </a>
                                   
                                    <a href="https://onlineauctionscript.digisamaritan.com/auctions/edit/butterfly-art-a1bb22cc237dae8603624090a38788c5ea2dc1b3-25" class="btn btn-xs btn-info"> Edit </a>
                                    
                                </td>


                            </tr><tr data-entry-id="26" role="row" class="even">
                              
                                <td style="text-align:center;">4</td>
                     
                                <td field-key="image"> <a href="https://onlineauctionscript.digisamaritan.com/public/uploads/auctions/_2l6i5IUiYQRtBFe.jpg" target="_blank"><img src="https://onlineauctionscript.digisamaritan.com/public/uploads/auctions/thumbnail/_2l6i5IUiYQRtBFe.jpg" alt="Art" width="50"> </a> </td>

                                <td> Art </td>

                                <td>  2024-09-25 12:49:00  </td>

                                <td>   2024-12-31 12:50:00  </td>

                                <td>500.00</td>
                                                                <td> <a href="https://onlineauctionscript.digisamaritan.com/users/view/seller-1" target="_blank" title="Seller Details"> seller</a></td>
                                                                <td>admin</td>

                                <td>open</td>

                                <td>approved</td>

                                <td>  

                                    2024-09-30 
                                    (
                                                                            06:00:00
                                    
                                    -

                                                                            19:00:00
                                                                        )
                                     </td>

                                <td>
                                    
                                    <a href="https://onlineauctionscript.digisamaritan.com/auctions/view/art-c36f67d3e1855a8b03c339e9f0005de1fa1df64e-24" class="btn btn-xs btn-primary"> View </a>
                                   
                                    <a href="https://onlineauctionscript.digisamaritan.com/auctions/edit/art-c36f67d3e1855a8b03c339e9f0005de1fa1df64e-24" class="btn btn-xs btn-info"> Edit </a>
                                    
                                </td>


                            </tr><tr data-entry-id="25" role="row" class="odd">
                              
                                <td style="text-align:center;">5</td>
                     
                                <td field-key="image"> <a href="https://onlineauctionscript.digisamaritan.com/public/uploads/auctions/default.png" target="_blank"><img src="https://onlineauctionscript.digisamaritan.com/public/uploads/auctions/thumbnail/default.png" alt="Samsung Ultra HD" width="50"> </a> </td>

                                <td> Samsung Ultra HD </td>

                                <td>  2018-04-10 11:34:00  </td>

                                <td>   2018-11-28 11:35:00  </td>

                                <td>35000.00</td>
                                                                <td> <a href="https://onlineauctionscript.digisamaritan.com/users/view/sai-13" target="_blank" title="Seller Details"> Sai</a></td>
                                                                <td>Sai</td>

                                <td>open</td>

                                <td>approved</td>

                                <td>  

                                    2018-07-13 
                                    (
                                                                            09:31:00
                                    
                                    -

                                                                            23:31:06
                                                                        )
                                     </td>

                                <td>
                                    
                                    <a href="https://onlineauctionscript.digisamaritan.com/auctions/view/samsung-ultra-hd-ccfc67455ee0dd7bce3f482168a3d7ca6d81294d-23" class="btn btn-xs btn-primary"> View </a>
                                   
                                    <a href="https://onlineauctionscript.digisamaritan.com/auctions/edit/samsung-ultra-hd-ccfc67455ee0dd7bce3f482168a3d7ca6d81294d-23" class="btn btn-xs btn-info"> Edit </a>
                                    
                                </td>


                            </tr><tr data-entry-id="23" role="row" class="even">
                              
                                <td style="text-align:center;">6</td>
                     
                                <td field-key="image"> <a href="https://onlineauctionscript.digisamaritan.com/public/uploads/auctions/23_Dwb91SoMboudNn0.jpeg" target="_blank"><img src="https://onlineauctionscript.digisamaritan.com/public/uploads/auctions/thumbnail/23_Dwb91SoMboudNn0.jpeg" alt="Columbia Grafonola" width="50"> </a> </td>

                                <td> Columbia Grafonola </td>

                                <td>  2018-02-13 14:35:00  </td>

                                <td>   2018-04-30 14:36:00  </td>

                                <td>8000.00</td>
                                                                <td> <a href="https://onlineauctionscript.digisamaritan.com/users/view/seller-1" target="_blank" title="Seller Details"> seller</a></td>
                                                                <td>admin</td>

                                <td>new</td>

                                <td>pending</td>

                                <td>  </td>

                                <td>
                                    
                                    <a href="https://onlineauctionscript.digisamaritan.com/auctions/view/columbia-grafonola-b6f2d919a833234abd84a9fd5729d52f53f996b3-22" class="btn btn-xs btn-primary"> View </a>
                                   
                                    <a href="https://onlineauctionscript.digisamaritan.com/auctions/edit/columbia-grafonola-b6f2d919a833234abd84a9fd5729d52f53f996b3-22" class="btn btn-xs btn-info"> Edit </a>
                                    
                                </td>


                            </tr><tr data-entry-id="22" role="row" class="odd">
                              
                                <td style="text-align:center;">7</td>
                     
                                <td field-key="image"> <a href="https://onlineauctionscript.digisamaritan.com/public/uploads/auctions/22_WXbjFzHHUyvxW0p.jpeg" target="_blank"><img src="https://onlineauctionscript.digisamaritan.com/public/uploads/auctions/thumbnail/22_WXbjFzHHUyvxW0p.jpeg" alt="Columbia Grafonola" width="50"> </a> </td>

                                <td> Columbia Grafonola </td>

                                <td>  2018-02-11 14:30:00  </td>

                                <td>   2018-04-30 14:31:00  </td>

                                <td>6000.00</td>
                                                                <td> <a href="https://onlineauctionscript.digisamaritan.com/users/view/seller-1" target="_blank" title="Seller Details"> seller</a></td>
                                                                <td>admin</td>

                                <td>closed</td>

                                <td>approved</td>

                                <td>  </td>

                                <td>
                                    
                                    <a href="https://onlineauctionscript.digisamaritan.com/auctions/view/columbia-grafonola-ac6a1ec911c46ca1a1f20bbb846d9b34866f1961-21" class="btn btn-xs btn-primary"> View </a>
                                   
                                    <a href="https://onlineauctionscript.digisamaritan.com/auctions/edit/columbia-grafonola-ac6a1ec911c46ca1a1f20bbb846d9b34866f1961-21" class="btn btn-xs btn-info"> Edit </a>
                                    
                                </td>


                            </tr><tr data-entry-id="21" role="row" class="even">
                              
                                <td style="text-align:center;">8</td>
                     
                                <td field-key="image"> <a href="https://onlineauctionscript.digisamaritan.com/public/uploads/auctions/21_8M3iYK4lK6jLSca.jpeg" target="_blank"><img src="https://onlineauctionscript.digisamaritan.com/public/uploads/auctions/thumbnail/21_8M3iYK4lK6jLSca.jpeg" alt="AN HMV MODEL 108 GRAMOPHONE, in dark oak casing, plus a selection " width="50"> </a> </td>

                                <td> AN HMV MODEL 108 GRAMOPHONE, in dark oak casing, plus a selection  </td>

                                <td>  2018-04-09 09:00:00  </td>

                                <td>   2018-04-30 14:21:00  </td>

                                <td>7000.00</td>
                                                                <td> <a href="https://onlineauctionscript.digisamaritan.com/users/view/jack-4" target="_blank" title="Seller Details"> jack</a></td>
                                                                <td>admin</td>

                                <td>open</td>

                                <td>approved</td>

                                <td>  

                                    2018-07-13 
                                    (
                                                                            09:33:03
                                    
                                    -

                                                                            23:33:06
                                                                        )
                                     </td>

                                <td>
                                    
                                    <a href="https://onlineauctionscript.digisamaritan.com/auctions/view/an-hmv-model-108-gramophone-in-dark-oak-casing-plus-a-selection-6f40bec66e478c9b229c26201d826cad5af8cf02-20" class="btn btn-xs btn-primary"> View </a>
                                   
                                    <a href="https://onlineauctionscript.digisamaritan.com/auctions/edit/an-hmv-model-108-gramophone-in-dark-oak-casing-plus-a-selection-6f40bec66e478c9b229c26201d826cad5af8cf02-20" class="btn btn-xs btn-info"> Edit </a>
                                    
                                </td>


                            </tr><tr data-entry-id="20" role="row" class="odd">
                              
                                <td style="text-align:center;">9</td>
                     
                                <td field-key="image"> <a href="https://onlineauctionscript.digisamaritan.com/public/uploads/auctions/20_94ZAPMvadlD9hOK.jpeg" target="_blank"><img src="https://onlineauctionscript.digisamaritan.com/public/uploads/auctions/thumbnail/20_94ZAPMvadlD9hOK.jpeg" alt="Tischgrammophon mit Platten" width="50"> </a> </td>

                                <td> Tischgrammophon mit Platten </td>

                                <td>  2024-09-30 10:18:00  </td>

                                <td>   2024-09-30 17:19:00  </td>

                                <td>7000.00</td>
                                                                <td> <a href="https://onlineauctionscript.digisamaritan.com/users/view/jack-4" target="_blank" title="Seller Details"> jack</a></td>
                                                                <td>admin</td>

                                <td>open</td>

                                <td>approved</td>

                                <td>  

                                    2024-09-30 
                                    (
                                                                            09:33:29
                                    
                                    -

                                                                            23:33:32
                                                                        )
                                     </td>

                                <td>
                                    
                                    <a href="https://onlineauctionscript.digisamaritan.com/auctions/view/tischgrammophon-mit-platten-1d0131da21d4fc0582a5f8e5a859181dbc3d8050-19" class="btn btn-xs btn-primary"> View </a>
                                   
                                    <a href="https://onlineauctionscript.digisamaritan.com/auctions/edit/tischgrammophon-mit-platten-1d0131da21d4fc0582a5f8e5a859181dbc3d8050-19" class="btn btn-xs btn-info"> Edit </a>
                                    
                                </td>


                            </tr><tr data-entry-id="19" role="row" class="even">
                              
                                <td style="text-align:center;">10</td>
                     
                                <td field-key="image"> <a href="https://onlineauctionscript.digisamaritan.com/public/uploads/auctions/19_QE6L5omAJUqjxuK.jpeg" target="_blank"><img src="https://onlineauctionscript.digisamaritan.com/public/uploads/auctions/thumbnail/19_QE6L5omAJUqjxuK.jpeg" alt="Vintage Macintosh Computer Full Set" width="50"> </a> </td>

                                <td> Vintage Macintosh Computer Full Set </td>

                                <td>  2018-02-16 14:14:00  </td>

                                <td>   2018-04-23 14:15:00  </td>

                                <td>60000.00</td>
                                                                <td> <a href="https://onlineauctionscript.digisamaritan.com/users/view/smith-6" target="_blank" title="Seller Details"> smith</a></td>
                                                                <td>admin</td>

                                <td>open</td>

                                <td>approved</td>

                                <td>  

                                    2018-07-13 
                                    (
                                                                            09:33:48
                                    
                                    -

                                                                            23:33:51
                                                                        )
                                     </td>

                                <td>
                                    
                                    <a href="https://onlineauctionscript.digisamaritan.com/auctions/view/vintage-macintosh-computer-full-set-37b8d1edf51935f4314f48572439daf8ad1563dd-18" class="btn btn-xs btn-primary"> View </a>
                                   
                                    <a href="https://onlineauctionscript.digisamaritan.com/auctions/edit/vintage-macintosh-computer-full-set-37b8d1edf51935f4314f48572439daf8ad1563dd-18" class="btn btn-xs btn-info"> Edit </a>
                                    
                                </td>


                            </tr><tr data-entry-id="18" role="row" class="odd">
                              
                                <td style="text-align:center;">11</td>
                     
                                <td field-key="image"> <a href="https://onlineauctionscript.digisamaritan.com/public/uploads/auctions/18_uKSyD2zKkhPB04a.jpeg" target="_blank"><img src="https://onlineauctionscript.digisamaritan.com/public/uploads/auctions/thumbnail/18_uKSyD2zKkhPB04a.jpeg" alt="MAC BOOK PRO A1286 4GB 15 IN LAPTOP FACTORY RESET" width="50"> </a> </td>

                                <td> MAC BOOK PRO A1286 4GB 15 IN LAPTOP FACTORY RESET </td>

                                <td>  2018-02-26 10:11:00  </td>

                                <td>   2024-09-26 22:00:00  </td>

                                <td>70000.00</td>
                                                                <td> <a href="https://onlineauctionscript.digisamaritan.com/users/view/smith-6" target="_blank" title="Seller Details"> smith</a></td>
                                                                <td>admin</td>

                                <td>open</td>

                                <td>approved</td>

                                <td>  

                                    2024-09-26 
                                    (
                                                                            10:34:09
                                    
                                    -

                                                                            14:34:11
                                                                        )
                                     </td>

                                <td>
                                    
                                    <a href="https://onlineauctionscript.digisamaritan.com/auctions/view/mac-book-pro-a1286-4gb-15-in-laptop-factory-reset-bc5c1a6865be8b6c60dcbfbee7e47b743e7759cd-17" class="btn btn-xs btn-primary"> View </a>
                                   
                                    <a href="https://onlineauctionscript.digisamaritan.com/auctions/edit/mac-book-pro-a1286-4gb-15-in-laptop-factory-reset-bc5c1a6865be8b6c60dcbfbee7e47b743e7759cd-17" class="btn btn-xs btn-info"> Edit </a>
                                    
                                </td>


                            </tr><tr data-entry-id="17" role="row" class="even">
                              
                                <td style="text-align:center;">12</td>
                     
                                <td field-key="image"> <a href="https://onlineauctionscript.digisamaritan.com/public/uploads/auctions/_Rn5VVWuzZw6taoB.jpeg" target="_blank"><img src="https://onlineauctionscript.digisamaritan.com/public/uploads/auctions/thumbnail/_Rn5VVWuzZw6taoB.jpeg" alt="Apple Macintosh SE/30 Computer &amp; Keyboard" width="50"> </a> </td>

                                <td> Apple Macintosh SE/30 Computer &amp; Keyboard </td>

                                <td>  2018-02-08 14:03:00  </td>

                                <td>   2018-04-30 14:04:00  </td>

                                <td>80000.00</td>
                                                                <td> <a href="https://onlineauctionscript.digisamaritan.com/users/view/smith-6" target="_blank" title="Seller Details"> smith</a></td>
                                                                <td>admin</td>

                                <td>new</td>

                                <td>approved</td>

                                <td>  </td>

                                <td>
                                    
                                    <a href="https://onlineauctionscript.digisamaritan.com/auctions/view/apple-macintosh-se30-computer-keyboard-f728035c012c6c385b32535d0b6ffe9242c21f8a-16" class="btn btn-xs btn-primary"> View </a>
                                   
                                    <a href="https://onlineauctionscript.digisamaritan.com/auctions/edit/apple-macintosh-se30-computer-keyboard-f728035c012c6c385b32535d0b6ffe9242c21f8a-16" class="btn btn-xs btn-info"> Edit </a>
                                    
                                </td>


                            </tr><tr data-entry-id="16" role="row" class="odd">
                              
                                <td style="text-align:center;">13</td>
                     
                                <td field-key="image"> <a href="https://onlineauctionscript.digisamaritan.com/public/uploads/auctions/16_Udlpib5wBEU71zM.jpeg" target="_blank"><img src="https://onlineauctionscript.digisamaritan.com/public/uploads/auctions/thumbnail/16_Udlpib5wBEU71zM.jpeg" alt="A Digital Hunting Camera model HC-600M/G" width="50"> </a> </td>

                                <td> A Digital Hunting Camera model HC-600M/G </td>

                                <td>  2018-02-08 12:22:00  </td>

                                <td>   2018-04-30 12:23:00  </td>

                                <td>500000.00</td>
                                                                <td> <a href="https://onlineauctionscript.digisamaritan.com/users/view/sai-13" target="_blank" title="Seller Details"> Sai</a></td>
                                                                <td>admin</td>

                                <td>open</td>

                                <td>approved</td>

                                <td>  

                                    2018-07-13 
                                    (
                                                                            09:34:40
                                    
                                    -

                                                                            23:34:43
                                                                        )
                                     </td>

                                <td>
                                    
                                    <a href="https://onlineauctionscript.digisamaritan.com/auctions/view/a-digital-hunting-camera-model-hc-600mg-dc2e584268a7ce72417b972a9e214a7777370844-15" class="btn btn-xs btn-primary"> View </a>
                                   
                                    <a href="https://onlineauctionscript.digisamaritan.com/auctions/edit/a-digital-hunting-camera-model-hc-600mg-dc2e584268a7ce72417b972a9e214a7777370844-15" class="btn btn-xs btn-info"> Edit </a>
                                    
                                </td>


                            </tr><tr data-entry-id="15" role="row" class="even">
                              
                                <td style="text-align:center;">14</td>
                     
                                <td field-key="image"> <a href="https://onlineauctionscript.digisamaritan.com/public/uploads/auctions/15_osKmezk4X1OCHmS.jpeg" target="_blank"><img src="https://onlineauctionscript.digisamaritan.com/public/uploads/auctions/thumbnail/15_osKmezk4X1OCHmS.jpeg" alt="Olympus and Carl Zeiss Jena Cameras. Collection of vintage SLR 35mm film cameras " width="50"> </a> </td>

                                <td> Olympus and Carl Zeiss Jena Cameras. Collection of vintage SLR 35mm film cameras  </td>

                                <td>  2018-02-07 12:20:00  </td>

                                <td>   2018-04-30 12:21:00  </td>

                                <td>500000.00</td>
                                                                <td> <a href="https://onlineauctionscript.digisamaritan.com/users/view/jack-4" target="_blank" title="Seller Details"> jack</a></td>
                                                                <td>admin</td>

                                <td>new</td>

                                <td>approved</td>

                                <td>  </td>

                                <td>
                                    
                                    <a href="https://onlineauctionscript.digisamaritan.com/auctions/view/olympus-and-carl-zeiss-jena-cameras-collection-of-vintage-slr-35mm-film-cameras-8d6f6ba30c19ca1b65781d16777a95838c104464-14" class="btn btn-xs btn-primary"> View </a>
                                   
                                    <a href="https://onlineauctionscript.digisamaritan.com/auctions/edit/olympus-and-carl-zeiss-jena-cameras-collection-of-vintage-slr-35mm-film-cameras-8d6f6ba30c19ca1b65781d16777a95838c104464-14" class="btn btn-xs btn-info"> Edit </a>
                                    
                                </td>


                            </tr><tr data-entry-id="14" role="row" class="odd">
                              
                                <td style="text-align:center;">15</td>
                     
                                <td field-key="image"> <a href="https://onlineauctionscript.digisamaritan.com/public/uploads/auctions/14_mIukJppMqTMDaZv.jpeg" target="_blank"><img src="https://onlineauctionscript.digisamaritan.com/public/uploads/auctions/thumbnail/14_mIukJppMqTMDaZv.jpeg" alt="A Collection of Vintage Cameras in Cases (4)" width="50"> </a> </td>

                                <td> A Collection of Vintage Cameras in Cases (4) </td>

                                <td>  2018-02-07 12:14:00  </td>

                                <td>   2018-04-30 12:15:00  </td>

                                <td>45000.00</td>
                                                                <td> <a href="https://onlineauctionscript.digisamaritan.com/users/view/jack-4" target="_blank" title="Seller Details"> jack</a></td>
                                                                <td>admin</td>

                                <td>new</td>

                                <td>approved</td>

                                <td>  </td>

                                <td>
                                    
                                    <a href="https://onlineauctionscript.digisamaritan.com/auctions/view/a-collection-of-vintage-cameras-in-cases-4-7dd11ea31faf3f2ad4c0e37c505042123d6a771e-13" class="btn btn-xs btn-primary"> View </a>
                                   
                                    <a href="https://onlineauctionscript.digisamaritan.com/auctions/edit/a-collection-of-vintage-cameras-in-cases-4-7dd11ea31faf3f2ad4c0e37c505042123d6a771e-13" class="btn btn-xs btn-info"> Edit </a>
                                    
                                </td>


                            </tr><tr data-entry-id="13" role="row" class="even">
                              
                                <td style="text-align:center;">16</td>
                     
                                <td field-key="image"> <a href="https://onlineauctionscript.digisamaritan.com/public/uploads/auctions/13_SOOGcKEpOtZ1d6v.jpeg" target="_blank"><img src="https://onlineauctionscript.digisamaritan.com/public/uploads/auctions/thumbnail/13_SOOGcKEpOtZ1d6v.jpeg" alt="Leica DBP Ernst Leitz Wetzlar Camera" width="50"> </a> </td>

                                <td> Leica DBP Ernst Leitz Wetzlar Camera </td>

                                <td>  2018-02-01 10:58:00  </td>

                                <td>   2018-04-30 10:59:00  </td>

                                <td>250000.00</td>
                                                                <td> <a href="https://onlineauctionscript.digisamaritan.com/users/view/jack-4" target="_blank" title="Seller Details"> jack</a></td>
                                                                <td>admin</td>

                                <td>new</td>

                                <td>approved</td>

                                <td>  </td>

                                <td>
                                    
                                    <a href="https://onlineauctionscript.digisamaritan.com/auctions/view/leica-dbp-ernst-leitz-wetzlar-camera-360dd1316c516e8b2fdbdf11a23f840e8c0e106a-12" class="btn btn-xs btn-primary"> View </a>
                                   
                                    <a href="https://onlineauctionscript.digisamaritan.com/auctions/edit/leica-dbp-ernst-leitz-wetzlar-camera-360dd1316c516e8b2fdbdf11a23f840e8c0e106a-12" class="btn btn-xs btn-info"> Edit </a>
                                    
                                </td>


                            </tr><tr data-entry-id="12" role="row" class="odd">
                              
                                <td style="text-align:center;">17</td>
                     
                                <td field-key="image"> <a href="https://onlineauctionscript.digisamaritan.com/public/uploads/auctions/12_syBtleScRfmXuXd.jpeg" target="_blank"><img src="https://onlineauctionscript.digisamaritan.com/public/uploads/auctions/thumbnail/12_syBtleScRfmXuXd.jpeg" alt="ALPA Reflex Model 9D with Kern Macro Switar 1.8/50 lens" width="50"> </a> </td>

                                <td> ALPA Reflex Model 9D with Kern Macro Switar 1.8/50 lens </td>

                                <td>  2018-02-07 11:54:00  </td>

                                <td>   2018-04-30 11:55:00  </td>

                                <td>45345345.00</td>
                                                                <td> <a href="https://onlineauctionscript.digisamaritan.com/users/view/seller-1" target="_blank" title="Seller Details"> seller</a></td>
                                                                <td>seller</td>

                                <td>open</td>

                                <td>approved</td>

                                <td>  

                                    2018-07-13 
                                    (
                                                                            09:35:01
                                    
                                    -

                                                                            23:35:04
                                                                        )
                                     </td>

                                <td>
                                    
                                    <a href="https://onlineauctionscript.digisamaritan.com/auctions/view/alpa-reflex-model-9d-with-kern-macro-switar-1850-lens-44dbc2ddbe6688894d128481b83c33549ce48092-12" class="btn btn-xs btn-primary"> View </a>
                                   
                                    <a href="https://onlineauctionscript.digisamaritan.com/auctions/edit/alpa-reflex-model-9d-with-kern-macro-switar-1850-lens-44dbc2ddbe6688894d128481b83c33549ce48092-12" class="btn btn-xs btn-info"> Edit </a>
                                    
                                </td>


                            </tr><tr data-entry-id="11" role="row" class="even">
                              
                                <td style="text-align:center;">18</td>
                     
                                <td field-key="image"> <a href="https://onlineauctionscript.digisamaritan.com/public/uploads/auctions/11_CramzjNHQq9ngG0.jpeg" target="_blank"><img src="https://onlineauctionscript.digisamaritan.com/public/uploads/auctions/thumbnail/11_CramzjNHQq9ngG0.jpeg" alt="Art Print by Nel Whatmore (Artist) NW0413" width="50"> </a> </td>

                                <td> Art Print by Nel Whatmore (Artist) NW0413 </td>

                                <td>  2018-02-09 05:00:00  </td>

                                <td>   2018-04-30 23:30:00  </td>

                                <td>300000.00</td>
                                                                <td> <a href="https://onlineauctionscript.digisamaritan.com/users/view/seller-1" target="_blank" title="Seller Details"> seller</a></td>
                                                                <td>seller</td>

                                <td>open</td>

                                <td>approved</td>

                                <td>  

                                    2018-07-13 
                                    (
                                                                            09:35:24
                                    
                                    -

                                                                            23:35:26
                                                                        )
                                     </td>

                                <td>
                                    
                                    <a href="https://onlineauctionscript.digisamaritan.com/auctions/view/art-print-by-nel-whatmore-artist-nw0413-8b1d8ddd64ae52cf650603a1ed76196a1a3dc3a4-10" class="btn btn-xs btn-primary"> View </a>
                                   
                                    <a href="https://onlineauctionscript.digisamaritan.com/auctions/edit/art-print-by-nel-whatmore-artist-nw0413-8b1d8ddd64ae52cf650603a1ed76196a1a3dc3a4-10" class="btn btn-xs btn-info"> Edit </a>
                                    
                                </td>


                            </tr><tr data-entry-id="10" role="row" class="odd">
                              
                                <td style="text-align:center;">19</td>
                     
                                <td field-key="image"> <a href="https://onlineauctionscript.digisamaritan.com/public/uploads/auctions/10_oaAMpSAvNvH3FVB.jpeg" target="_blank"><img src="https://onlineauctionscript.digisamaritan.com/public/uploads/auctions/thumbnail/10_oaAMpSAvNvH3FVB.jpeg" alt="Carat Genuine Amethyst and White Topaz .925 Sterling Silver Ring" width="50"> </a> </td>

                                <td> Carat Genuine Amethyst and White Topaz .925 Sterling Silver Ring </td>

                                <td>  2018-02-09 17:00:00  </td>

                                <td>   2027-01-01 17:00:00  </td>

                                <td>600000.00</td>
                                                                <td> <a href="https://onlineauctionscript.digisamaritan.com/users/view/seller-1" target="_blank" title="Seller Details"> seller</a></td>
                                                                <td>seller</td>

                                <td>open</td>

                                <td>approved</td>

                                <td>  

                                    2024-12-31 
                                    (
                                                                            09:35:43
                                    
                                    -

                                                                            23:35:47
                                                                        )
                                     </td>

                                <td>
                                    
                                    <a href="https://onlineauctionscript.digisamaritan.com/auctions/view/carat-genuine-amethyst-and-white-topaz-925-sterling-silver-ring-002e61fc2145d4228376cac1ec07f842c6b63e53-9" class="btn btn-xs btn-primary"> View </a>
                                   
                                    <a href="https://onlineauctionscript.digisamaritan.com/auctions/edit/carat-genuine-amethyst-and-white-topaz-925-sterling-silver-ring-002e61fc2145d4228376cac1ec07f842c6b63e53-9" class="btn btn-xs btn-info"> Edit </a>
                                    
                                </td>


                            </tr><tr data-entry-id="9" role="row" class="even">
                              
                                <td style="text-align:center;">20</td>
                     
                                <td field-key="image"> <a href="https://onlineauctionscript.digisamaritan.com/public/uploads/auctions/9_NGePxCgD7UOP0jR.jpeg" target="_blank"><img src="https://onlineauctionscript.digisamaritan.com/public/uploads/auctions/thumbnail/9_NGePxCgD7UOP0jR.jpeg" alt="Designer Fine Jewelry &amp; Watches Closeout Event Day 2... FREE SHIPPING" width="50"> </a> </td>

                                <td> Designer Fine Jewelry &amp; Watches Closeout Event Day 2... FREE SHIPPING </td>

                                <td>  2018-02-09 16:00:00  </td>

                                <td>   2018-04-30 16:00:00  </td>

                                <td>500000.00</td>
                                                                <td> <a href="https://onlineauctionscript.digisamaritan.com/users/view/seller-1" target="_blank" title="Seller Details"> seller</a></td>
                                                                <td>admin</td>

                                <td>open</td>

                                <td>approved</td>

                                <td>  

                                    2018-07-13 
                                    (
                                                                            09:36:02
                                    
                                    -

                                                                            23:36:05
                                                                        )
                                     </td>

                                <td>
                                    
                                    <a href="https://onlineauctionscript.digisamaritan.com/auctions/view/designer-fine-jewelry-watches-closeout-event-day-2-free-shipping-ef5743a4feea8db74eba8a5be9b562ff80ba4647-8" class="btn btn-xs btn-primary"> View </a>
                                   
                                    <a href="https://onlineauctionscript.digisamaritan.com/auctions/edit/designer-fine-jewelry-watches-closeout-event-day-2-free-shipping-ef5743a4feea8db74eba8a5be9b562ff80ba4647-8" class="btn btn-xs btn-info"> Edit </a>
                                    
                                </td>


                            </tr><tr data-entry-id="8" role="row" class="odd">
                              
                                <td style="text-align:center;">21</td>
                     
                                <td field-key="image"> <a href="https://onlineauctionscript.digisamaritan.com/public/uploads/auctions/8_2l0qBV5eJvTDQ61.jpeg" target="_blank"><img src="https://onlineauctionscript.digisamaritan.com/public/uploads/auctions/thumbnail/8_2l0qBV5eJvTDQ61.jpeg" alt="Reply of the Zaporozhian Cossacks to Sultan Mehmed IV Painting after Ilya Repin" width="50"> </a> </td>

                                <td> Reply of the Zaporozhian Cossacks to Sultan Mehmed IV Painting after Ilya Repin </td>

                                <td>  2018-02-08 16:00:00  </td>

                                <td>   2018-04-30 21:00:00  </td>

                                <td>400000.00</td>
                                                                <td> <a href="https://onlineauctionscript.digisamaritan.com/users/view/seller-1" target="_blank" title="Seller Details"> seller</a></td>
                                                                <td>seller</td>

                                <td>open</td>

                                <td>approved</td>

                                <td>  

                                    2018-07-13 
                                    (
                                                                            09:36:20
                                    
                                    -

                                                                            23:36:22
                                                                        )
                                     </td>

                                <td>
                                    
                                    <a href="https://onlineauctionscript.digisamaritan.com/auctions/view/reply-of-the-zaporozhian-cossacks-to-sultan-mehmed-iv-painting-after-ilya-repin-d47b9ccbd0d365fa588d146c7e8e01d35872783d-7" class="btn btn-xs btn-primary"> View </a>
                                   
                                    <a href="https://onlineauctionscript.digisamaritan.com/auctions/edit/reply-of-the-zaporozhian-cossacks-to-sultan-mehmed-iv-painting-after-ilya-repin-d47b9ccbd0d365fa588d146c7e8e01d35872783d-7" class="btn btn-xs btn-info"> Edit </a>
                                    
                                </td>


                            </tr><tr data-entry-id="7" role="row" class="even">
                              
                                <td style="text-align:center;">22</td>
                     
                                <td field-key="image"> <a href="https://onlineauctionscript.digisamaritan.com/public/uploads/auctions/7_IdkTmhuyIUW4OKR.jpeg" target="_blank"><img src="https://onlineauctionscript.digisamaritan.com/public/uploads/auctions/thumbnail/7_IdkTmhuyIUW4OKR.jpeg" alt="CAROLINE BURNETT PARISIAN OIL ON CANVAS V$3,000" width="50"> </a> </td>

                                <td> CAROLINE BURNETT PARISIAN OIL ON CANVAS V$3,000 </td>

                                <td>  2018-02-14 13:00:00  </td>

                                <td>   2018-04-30 13:00:00  </td>

                                <td>300000.00</td>
                                                                <td> <a href="https://onlineauctionscript.digisamaritan.com/users/view/seller-1" target="_blank" title="Seller Details"> seller</a></td>
                                                                <td>seller</td>

                                <td>open</td>

                                <td>approved</td>

                                <td>  

                                    2018-07-13 
                                    (
                                                                            09:36:40
                                    
                                    -

                                                                            23:36:42
                                                                        )
                                     </td>

                                <td>
                                    
                                    <a href="https://onlineauctionscript.digisamaritan.com/auctions/view/caroline-burnett-parisian-oil-on-canvas-v3000-9ff90a0c0fa7b74285f14d1bc12c10c0b8498541-6" class="btn btn-xs btn-primary"> View </a>
                                   
                                    <a href="https://onlineauctionscript.digisamaritan.com/auctions/edit/caroline-burnett-parisian-oil-on-canvas-v3000-9ff90a0c0fa7b74285f14d1bc12c10c0b8498541-6" class="btn btn-xs btn-info"> Edit </a>
                                    
                                </td>


                            </tr><tr data-entry-id="6" role="row" class="odd">
                              
                                <td style="text-align:center;">23</td>
                     
                                <td field-key="image"> <a href="https://onlineauctionscript.digisamaritan.com/public/uploads/auctions/6_nlRTmO3qt2kSMFg.jpeg" target="_blank"><img src="https://onlineauctionscript.digisamaritan.com/public/uploads/auctions/thumbnail/6_nlRTmO3qt2kSMFg.jpeg" alt="Camille Bombois, French (1883-1970), Girls Playing Catch, oil on canvas, 23 1/2 x 29 inches" width="50"> </a> </td>

                                <td> Camille Bombois, French (1883-1970), Girls Playing Catch, oil on canvas, 23 1/2 x 29 inches </td>

                                <td>  2018-02-08 08:00:00  </td>

                                <td>   2018-04-30 17:00:00  </td>

                                <td>450000.00</td>
                                                                <td> <a href="https://onlineauctionscript.digisamaritan.com/users/view/seller-1" target="_blank" title="Seller Details"> seller</a></td>
                                                                <td>admin</td>

                                <td>new</td>

                                <td>approved</td>

                                <td>  </td>

                                <td>
                                    
                                    <a href="https://onlineauctionscript.digisamaritan.com/auctions/view/camille-bombois-french-1883-1970-girls-playing-catch-oil-on-canvas-23-12-x-29-inches-d3ecea2d24547cc90b55ae0ac48f07de29c4505b-5" class="btn btn-xs btn-primary"> View </a>
                                   
                                    <a href="https://onlineauctionscript.digisamaritan.com/auctions/edit/camille-bombois-french-1883-1970-girls-playing-catch-oil-on-canvas-23-12-x-29-inches-d3ecea2d24547cc90b55ae0ac48f07de29c4505b-5" class="btn btn-xs btn-info"> Edit </a>
                                    
                                </td>


                            </tr><tr data-entry-id="5" role="row" class="even">
                              
                                <td style="text-align:center;">24</td>
                     
                                <td field-key="image"> <a href="https://onlineauctionscript.digisamaritan.com/public/uploads/auctions/5_KuShHfLk5PxO0tD.jpeg" target="_blank"><img src="https://onlineauctionscript.digisamaritan.com/public/uploads/auctions/thumbnail/5_KuShHfLk5PxO0tD.jpeg" alt="3 1/2 CARAT AMETHYST 925 STERLING SILVER SET" width="50"> </a> </td>

                                <td> 3 1/2 CARAT AMETHYST 925 STERLING SILVER SET </td>

                                <td>  2018-02-13 10:00:00  </td>

                                <td>   2018-04-30 10:00:00  </td>

                                <td>560000.00</td>
                                                                <td> <a href="https://onlineauctionscript.digisamaritan.com/users/view/seller-1" target="_blank" title="Seller Details"> seller</a></td>
                                                                <td>admin</td>

                                <td>open</td>

                                <td>approved</td>

                                <td>  

                                    2018-07-13 
                                    (
                                                                            09:36:58
                                    
                                    -

                                                                            23:37:00
                                                                        )
                                     </td>

                                <td>
                                    
                                    <a href="https://onlineauctionscript.digisamaritan.com/auctions/view/3-12-carat-amethyst-925-sterling-silver-set-4ed944c3fcd26979785279e4e2f31d1fd7116b2a-4" class="btn btn-xs btn-primary"> View </a>
                                   
                                    <a href="https://onlineauctionscript.digisamaritan.com/auctions/edit/3-12-carat-amethyst-925-sterling-silver-set-4ed944c3fcd26979785279e4e2f31d1fd7116b2a-4" class="btn btn-xs btn-info"> Edit </a>
                                    
                                </td>


                            </tr><tr data-entry-id="4" role="row" class="odd">
                              
                                <td style="text-align:center;">25</td>
                     
                                <td field-key="image"> <a href="https://onlineauctionscript.digisamaritan.com/public/uploads/auctions/4_X0fkr3qYIjNnVjV.jpeg" target="_blank"><img src="https://onlineauctionscript.digisamaritan.com/public/uploads/auctions/thumbnail/4_X0fkr3qYIjNnVjV.jpeg" alt="2 14 CARAT AMETHYSTS 925 STERLING SILVER" width="50"> </a> </td>

                                <td> 2 14 CARAT AMETHYSTS 925 STERLING SILVER </td>

                                <td>  2018-02-08 16:00:00  </td>

                                <td>   2018-04-30 16:00:00  </td>

                                <td>300000.00</td>
                                                                <td> <a href="https://onlineauctionscript.digisamaritan.com/users/view/seller-1" target="_blank" title="Seller Details"> seller</a></td>
                                                                <td>admin</td>

                                <td>open</td>

                                <td>approved</td>

                                <td>  

                                    2018-07-13 
                                    (
                                                                            09:37:17
                                    
                                    -

                                                                            23:37:22
                                                                        )
                                     </td>

                                <td>
                                    
                                    <a href="https://onlineauctionscript.digisamaritan.com/auctions/view/2-14-carat-amethysts-925-sterling-silver-34567b70234e96a1641fc5ae92461fb845b6322f-3" class="btn btn-xs btn-primary"> View </a>
                                   
                                    <a href="https://onlineauctionscript.digisamaritan.com/auctions/edit/2-14-carat-amethysts-925-sterling-silver-34567b70234e96a1641fc5ae92461fb845b6322f-3" class="btn btn-xs btn-info"> Edit </a>
                                    
                                </td>


                            </tr><tr data-entry-id="3" role="row" class="even">
                              
                                <td style="text-align:center;">26</td>
                     
                                <td field-key="image"> <a href="https://onlineauctionscript.digisamaritan.com/public/uploads/auctions/3_Wj1xoVbl6fOsdpJ.jpeg" target="_blank"><img src="https://onlineauctionscript.digisamaritan.com/public/uploads/auctions/thumbnail/3_Wj1xoVbl6fOsdpJ.jpeg" alt="Bulgari Yellow Gold B.Zero.1 Ring c.1980" width="50"> </a> </td>

                                <td> Bulgari Yellow Gold B.Zero.1 Ring c.1980 </td>

                                <td>  2018-02-18 12:00:00  </td>

                                <td>   2018-04-30 16:00:00  </td>

                                <td>500000.00</td>
                                                                <td> <a href="https://onlineauctionscript.digisamaritan.com/users/view/seller-1" target="_blank" title="Seller Details"> seller</a></td>
                                                                <td>seller</td>

                                <td>new</td>

                                <td>approved</td>

                                <td>  </td>

                                <td>
                                    
                                    <a href="https://onlineauctionscript.digisamaritan.com/auctions/view/bulgari-yellow-gold-bzero1-ring-c1980-8a01fcd70bf735dfabc58846ff83eae9bb27fc40-2" class="btn btn-xs btn-primary"> View </a>
                                   
                                    <a href="https://onlineauctionscript.digisamaritan.com/auctions/edit/bulgari-yellow-gold-bzero1-ring-c1980-8a01fcd70bf735dfabc58846ff83eae9bb27fc40-2" class="btn btn-xs btn-info"> Edit </a>
                                    
                                </td>


                            </tr><tr data-entry-id="2" role="row" class="odd">
                              
                                <td style="text-align:center;">27</td>
                     
                                <td field-key="image"> <a href="https://onlineauctionscript.digisamaritan.com/public/uploads/auctions/2_ICNuTUgnpLQ8Qq1.jpeg" target="_blank"><img src="https://onlineauctionscript.digisamaritan.com/public/uploads/auctions/thumbnail/2_ICNuTUgnpLQ8Qq1.jpeg" alt="Bulgari Bvlgari B.Zero1 Bangle Bracelet" width="50"> </a> </td>

                                <td> Bulgari Bvlgari B.Zero1 Bangle Bracelet </td>

                                <td>  2018-02-18 11:00:00  </td>

                                <td>   2018-04-30 11:00:00  </td>

                                <td>200000.00</td>
                                                                <td> <a href="https://onlineauctionscript.digisamaritan.com/users/view/seller-1" target="_blank" title="Seller Details"> seller</a></td>
                                                                <td>seller</td>

                                <td>open</td>

                                <td>approved</td>

                                <td>  

                                    2018-07-13 
                                    (
                                                                            09:37:29
                                    
                                    -

                                                                            23:37:31
                                                                        )
                                     </td>

                                <td>
                                    
                                    <a href="https://onlineauctionscript.digisamaritan.com/auctions/view/bulgari-bvlgari-bzero1-bangle-bracelet-f63e5827dca043b7e48f5ae2815b4dad7ace0d26-1" class="btn btn-xs btn-primary"> View </a>
                                   
                                    <a href="https://onlineauctionscript.digisamaritan.com/auctions/edit/bulgari-bvlgari-bzero1-bangle-bracelet-f63e5827dca043b7e48f5ae2815b4dad7ace0d26-1" class="btn btn-xs btn-info"> Edit </a>
                                    
                                </td>


                            </tr><tr data-entry-id="1" role="row" class="even">
                              
                                <td style="text-align:center;">28</td>
                     
                                <td field-key="image"> <a href="https://onlineauctionscript.digisamaritan.com/public/uploads/auctions/1_xJKfIjzQWy7TRab.jpeg" target="_blank"><img src="https://onlineauctionscript.digisamaritan.com/public/uploads/auctions/thumbnail/1_xJKfIjzQWy7TRab.jpeg" alt="Landschap met schaatsers" width="50"> </a> </td>

                                <td> Landschap met schaatsers </td>

                                <td>  2018-02-13 16:00:00  </td>

                                <td>   2018-04-30 17:00:00  </td>

                                <td>200000.00</td>
                                                                <td> <a href="https://onlineauctionscript.digisamaritan.com/users/view/seller-1" target="_blank" title="Seller Details"> seller</a></td>
                                                                <td>admin</td>

                                <td>closed</td>

                                <td>approved</td>

                                <td>  </td>

                                <td>
                                    
                                    <a href="https://onlineauctionscript.digisamaritan.com/auctions/view/landschap-met-schaatsers-902f22426277aaa6ad8060fcf2e25544b3f39cd0" class="btn btn-xs btn-primary"> View </a>
                                   
                                    <a href="https://onlineauctionscript.digisamaritan.com/auctions/edit/landschap-met-schaatsers-902f22426277aaa6ad8060fcf2e25544b3f39cd0" class="btn btn-xs btn-info"> Edit </a>
                                    
                                </td>


                            </tr></tbody>
                            </table><div class="dataTables_info" id="DataTables_Table_0_info" role="status" aria-live="polite">Showing 1 to 28 of 28 entries</div><div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_0_paginate"><a class="paginate_button previous disabled" aria-controls="DataTables_Table_0" data-dt-idx="0" tabindex="0" id="DataTables_Table_0_previous">Previous</a><span><a class="paginate_button current" aria-controls="DataTables_Table_0" data-dt-idx="1" tabindex="0">1</a></span><a class="paginate_button next disabled" aria-controls="DataTables_Table_0" data-dt-idx="2" tabindex="0" id="DataTables_Table_0_next">Next</a></div><div class="actions"></div></div>
        </div>
</div>
@endsection
