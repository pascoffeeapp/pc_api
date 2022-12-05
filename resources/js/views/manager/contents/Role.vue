<template>
            <!-- <img src="assets/coffee_content.svg" alt=""> -->
            <div class="container py-3">
                <h1>Role</h1>
                    
                <div class="rounded shadow-sm p-3 bg-white">

                    <div class="container mb-5">
                        <div class="row row-cols-2">
                            <div class="col-sm-7"><!-- + Add Button -->
                                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modal-add-role">
                                        + Add
                                    </button>
                                    
                                    <!-- Modal -->
                                    <div class="modal fade" id="modal-add-role" tabindex="-1" aria-labelledby="modal-add-roleLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="modal-add-roleLabel">Edit Role</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        
                                                        <div class="mb-3">
                                                            <label for="exampleFormControlInput1" class="form-label"><b>Name :</b></label>
                                                            <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="name or username">
                                                        </div>
                                                        
                                                        <br><b>Role :</b>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                                            <label class="form-check-label" for="flexCheckDefault">
                                                            Owner
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                                            <label class="form-check-label" for="flexCheckChecked">
                                                            Admin
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                                            <label class="form-check-label" for="flexCheckDefault">
                                                            Cashier
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                                            <label class="form-check-label" for="flexCheckDefault">
                                                            Owner Outlet
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                                            <label class="form-check-label" for="flexCheckDefault">
                                                            Manager
                                                            </label>
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
                            <th class="col-sm-5">Name</th>
                            <th class="col-sm-2">Edit</th>
                            <th class="col-sm-2">Delete</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <th scope="row">1</th>
                            <th scope="row">MUHAMMAD MUNAWIR</th>
                            <td><!--Button edit role-->
                                <!-- Button trigger modal -->
                                <div class="d-grid gap-2 mx-auto">
                                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modal-edit-role">
                                    <i class="fa fa-solid fa-pen-to-square"></i>
                                </button>
                                </div>
                                <!-- Modal -->
                                <div class="modal fade" id="modal-edit-role" tabindex="-1" aria-labelledby="modal-edit-roleLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="modal-editLabel">Edit Role</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    
                                                    <div class="mb-3">
                                                        <label for="exampleFormControlInput1" class="form-label"><b>Name :</b></label>
                                                        <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="name or username">
                                                    </div>
                                                    
                                                    <br><b>Role :</b>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                                        <label class="form-check-label" for="flexCheckDefault">
                                                        Owner
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked>
                                                        <label class="form-check-label" for="flexCheckChecked">
                                                        Admin
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                                        <label class="form-check-label" for="flexCheckDefault">
                                                        Cashier
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                                        <label class="form-check-label" for="flexCheckDefault">
                                                        Owner Outlet
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                                        <label class="form-check-label" for="flexCheckDefault">
                                                        Manager
                                                        </label>
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
</template>