@extends('layouts.app')

@section('title', 'Data Master Mahasiswa')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Mahasiswa</h1>
                <div class="section-header-button">
                    <a href="{{ route('students.create') }}" class="btn btn-primary">Add New</a>
                </div>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Student</a></div>
                    <div class="breadcrumb-item">All Students</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        @include('layouts.alert')
                    </div>
                </div>
                <h2 class="section-title">Mahasiswa</h2>
                <p class="section-lead">
                    You can manage all Students, such as editing, deleting and more.
                </p>


                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>All Students</h4>
                            </div>
                            <div class="card-body">

                                <div class="float-right">
                                    <form method="GET" action="{{ route('students.index') }}">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Search" name="search">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <div class="clearfix mb-3"></div>

                                <div class="table-responsive">
                                    <table class="table-striped table">
                                        <tr>

                                            <th>#</th>
                                            <th>NIM</th>
                                            <th>Nama</th>
                                            <th>Program Studi</th>
                                            <th>Telepon</th>
                                            <th>Alamat</th>
                                            <th>Angkatan</th>
                                            <th>Status</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                        @foreach ($students as $student)
                                            <tr>

                                                <td>
                                                    {{ $loop->iteration }}
                                                </td>
                                                <td>
                                                    {{ $student->nim }}
                                                </td>
                                                <td>
                                                    {{ $student->name }}
                                                </td>
                                                <td>
                                                    {{ $student->studyProgram->nama_prodi }}
                                                </td>
                                                <td>
                                                    {{ $student->telepon }}
                                                </td>
                                                <td>
                                                    {{ $student->alamat }}
                                                </td>
                                                <td>
                                                    {{ $student->angkatan }}
                                                </td>
                                                <td>
                                                    <span
                                                        class="badge 
                                                        {{ $student->status == 'aktif' ? 'badge-success' : '' }}
                                                        {{ $student->status == 'tidak aktif' ? 'badge-danger' : '' }}
                                                        {{ $student->status == 'cuti' ? 'badge-warning' : '' }}
                                                        {{ $student->status == 'lulus' ? 'badge-primary' : '' }}">
                                                        {{ ucfirst($student->status) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="d-flex justify-content-center">
                                                        <a href='{{ route('students.edit', $student->id) }}'
                                                            class="btn btn-sm btn-info btn-icon">
                                                            <i class="fas fa-edit"></i>
                                                            Edit
                                                        </a>

                                                        <form action="{{ route('students.destroy', $student->id) }}"
                                                            method="POST" class="ml-2">
                                                            <input type="hidden" name="_method" value="DELETE" />
                                                            <input type="hidden" name="_token"
                                                                value="{{ csrf_token() }}" />
                                                            <button class="btn btn-sm btn-danger btn-icon confirm-delete">
                                                                <i class="fas fa-times"></i> Delete
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach


                                    </table>
                                </div>
                                <div class="float-right">
                                    {{ $students->withQueryString()->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/features-posts.js') }}"></script>
@endpush
