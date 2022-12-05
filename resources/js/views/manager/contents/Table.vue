<template>
    <div id="content">
        <!-- <img src="assets/coffee_content.svg" alt=""> -->
        <div class="container py-3">
            <h1>Tables</h1>

            <div class="rounded shadow-sm p-3 bg-white">

                <div class="container mb-5">
                    <div class="row row-cols-2">
                        <div class="col-sm-7">
                            <!-- + Add Button -->
                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                    + Add
                                </button>

                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Add Table</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">

                                            <div class="mb-3">
                                                <label for="exampleFormControlInput1" class="form-label"><b>Code Table :</b></label>
                                                <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="name or username">
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

                            <th class="col-sm-2">Code Table</th>
                            <th class="col-sm-2">Edit</th>
                            <th class="col-sm-2">Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th class="d-grid mx-auto">1</th>

                            <td>
                                <!--Button edit role-->
                                <!-- Button trigger modal -->
                                <div class="d-grid gap-2 mx-auto">
                                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#exampleModa2">
                                <i class="fa fa-solid fa-pen-to-square"></i>
                            </button>
                                </div>
                                <!-- Modal -->
                                <div class="modal fade" id="exampleModa2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabe2">Add Role</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">

                                                <div class="mb-3">
                                                    <label for="exampleFormControlInput1" class="form-label"><b>Code Table :</b></label>
                                                    <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="name or username">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="exampleFormControlInput1" class="form-label"><b>New Code Table :</b></label>
                                                    <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="name or username">
                                                </div>

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="button" class="btn btn-primary">Save changes</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <!--Button delete role-->
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