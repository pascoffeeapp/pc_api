<template>
    <div id="content">
        <!-- <img src="assets/coffee_content.svg" alt=""> -->
        <div class="container py-3">
            <h1>Outlet</h1>
                
            <div class="rounded shadow-sm p-3 bg-white">

                <div class="container mb-5">
                    <div class="row row-cols-2">
                        <div class="col-sm-7"><!-- + Add Button -->
                                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modal-add-outlet">
                                    + Add Outlet
                                </button>
                                
                                <!-- Modal -->
                                <div class="modal fade" id="modal-add-outlet" tabindex="-1" aria-labelledby="modal-add-outletLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="modal-add-outletLabel">Add Outlet</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                
                                                <div class="mb-3">
                                                    <label for="exampleFormControlInput1" class="form-label"><b>Outlet Name :</b></label>
                                                    <input type="username" class="form-control" id="exampleFormControlInput1" placeholder="Outlet name">
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <label for="exampleFormControlInput2" class="form-label"><b>Description :</b></label>
                                                    <br><textarea class="form-control" id="exampleFormControlInput2" placeholder="Description"></textarea>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="exampleFormControlInput3" class="form-label"><b>Owner :</b></label>
                                                    <input type="name" class="form-control" id="exampleFormControlInput3" placeholder="Owner name">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="formFile" class="form-label"><b>Picture :</b></label>
                                                    <input class="form-control" type="file" id="formFile">
                                                </div>
                                                </div>
                                            <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-success">Submit</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                        <div class="col-sm-3 ms-auto">
                            <form class="d-flex" role="search">
                                <input class="form-control me-2 " type="search" placeholder="Search" aria-label="Search">
                                <button class="btn btn-outline-success" type="submit">Search</button>
                            </form>
                        </div>
                    </div>
                </div>
                
                <!--Table content-->
                <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th class="col-sm-1">#</th>
                        <th class="col-sm-3">Outlet Name</th>
                        <th class="col-sm-4">Owner</th>
                        <th class="col-sm-1">Edit</th>
                        <th class="col-sm-1">Delete</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <th scope="row">1</th>
                        <th>SOTO</th>
                        <th>RIZKI ILHAMI</th>
                        <td><!--Button edit role-->
                            <!-- Button trigger modal -->
                            <div class="d-grid gap-2 mx-auto">
                                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modal-edit-outlet">
                                    <i class="fa fa-solid fa-pen-to-square"></i>
                                </button>
                            </div>
                            <!-- Modal edit -->
                            <div class="modal fade" id="modal-edit-outlet" tabindex="-1" aria-labelledby="modal-edit-outletLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="modal-edit-outletLabel">Edit Outlet</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                            
                                            <div class="mb-3">
                                                <label for="exampleFormControlInput1" class="form-label"><b>Outlet Name :</b></label>
                                                <input type="username" class="form-control" id="exampleFormControlInput1" placeholder="Outlet name">
                                            </div>
                                            
                                            <div class="mb-3">
                                                <label for="exampleFormControlInput2" class="form-label"><b>Description :</b></label>
                                                <br><textarea class="form-control" id="exampleFormControlInput2" placeholder="Description"></textarea>
                                            </div>

                                            <div class="mb-3">
                                                <label for="exampleFormControlInput3" class="form-label"><b>Owner :</b></label>
                                                <input type="name" class="form-control" id="exampleFormControlInput3" placeholder="Owner name">
                                            </div>
                                            <div class="mb-3">
                                                <label for="formFile" class="form-label"><b>Picture :</b></label>
                                                <input class="form-control" type="file" id="formFile">
                                            </div>
                                            </div>
                                        <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-success">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                                           
                        </td>
                        <td><!--Button delete role-->
                            <!-- Button trigger modal -->
                            <div class="d-grid gap-2 mx-auto">
                            <button type="button" class="btn btn-danger">
                                <i class="fa fa-solid fa-trash-can"></i>
                            </button>
                            </div>
                        </td>
                      </tr>

                    </tbody>
                  </table>
            </div>
        </div>
    </div>
</template>