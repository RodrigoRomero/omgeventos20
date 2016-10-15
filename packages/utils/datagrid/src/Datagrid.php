<?php namespace OMG\Datagrid;



class Datagrid 
{
    public function make($grid)
    {


        return view('datagrid::datagrid', compact('route', 'image'));
    }
}