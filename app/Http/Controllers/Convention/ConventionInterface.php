<?php

namespace App\Http\Controllers\Convention;
use Illuminate\Http\Request;

interface ConventionInterface
{

    public function edit($id);
    public function update(Request  $request, $id);
    public function generate($id);
    public function download($id);
    public function destroy($id);

}
