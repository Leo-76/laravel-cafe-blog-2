@extends('layouts.app')

@section('title', 'Editer : ' . $post->title)

@section('content')
@include('admin.posts.create')
@endsection
