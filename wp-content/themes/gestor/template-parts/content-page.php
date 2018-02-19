<?php
/**
 * Created by PhpStorm.
 * User: mauro
 * Date: 16/02/18
 * Time: 11:12
 */
?>

<div class="container">
    <div class="py-5 text-center">
        <img class="d-block mx-auto mb-4" src="https://getbootstrap.com/assets/brand/bootstrap-solid.svg" alt="" width="72" height="72">
        <h2><?php the_title(); ?></h2>
        <p class="lead">Reserva la teva furgoneta</p>
    </div>

    <div class="row">
        <form class="col-md-12">
            <div class="form-group row">
                <label for="data-ini" class="col-sm-2 col-form-label">Data inici</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="datepicker-ini">
                </div>
            </div>
            <div class="form-group row">
                <label for="data-fi" class="col-sm-2 col-form-label">Data Fi</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="datepicker-fi">
                </div>
            </div>

            <div class="form-group row">
                <label for="lloc-recollida" class="col-sm-2 col-form-label">Lloc recollida</label>
                <div class="col-sm-10">
                    <select class="form-control">
                        <option>Opcio1</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="lloc-tornada" class="col-sm-2 col-form-label">Lloc de tornada</label>
                <div class="col-sm-10">
                    <select class="form-control">
                        <option>Opcio1</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="lloc-tornada" class="col-sm-2 col-form-label">Numero d'ocupants</label>
                <div class="col-sm-10">
                    <select class="form-control">
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                        <option>5</option>
                    </select>
                </div>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                <label class="form-check-label" for="defaultCheck1">
                    Viatges amb animals?
                </label>
            </div>

            <button type="submit" class="btn btn-primary btn-lg">CERCAR</button>
        </form>

    </div>

</div>