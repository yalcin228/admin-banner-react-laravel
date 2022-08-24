import React, {useEffect, useState} from 'react';
import axios from "axios";
import {Link} from "react-router-dom";
import Button from "react-bootstrap/Button";
import Pagination from "react-js-pagination";
import Swal from "sweetalert2";
import SideBar from "../../components/SideBar";
import Navbar from "../../components/Navbar";
import Footer from "../../components/Footer";
import ClipLoader from "react-spinners/ClipLoader";


function BannerIndex(props) {
    const token = JSON.parse(localStorage.getItem('authInfo'));
    const [banners, setBanners] = useState([]);
    const [loading,setLoading] = useState(false);

    useEffect(() => {
        setLoading(true);
        getBannersData();
    }, []);

    const getBannersData = async (pageNumber = 1) => {
        await axios.get(`http://127.0.0.1:8000/api/banner?page=${pageNumber}`,{
            'headers':{
                "Authorization": `Bearer ${token.access_token}`
            }
        }).then((response) => {
            setLoading(false);
            setBanners(response)
        });
    }

    const deleteBanner = async (id) => {
        const isConfirm = await Swal.fire({
            title: 'Əminsiniz?',
            text: "Bunu geri qaytara bilməyəcəksiniz!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Xeyr',
            confirmButtonText: 'Bəli, silin!'
        }).then((result) => {
            return result.isConfirmed
        });

        if (!isConfirm) {
            return;
        }

        await axios.delete(`http://127.0.0.1:8000/api/banner/${id}`).then((response) => {
            Swal.fire({
                icon: "success",
                text: response.message
            })
            getBannersData();
        }).catch(({response: {response}}) => {
            Swal.fire({
                text: response.message,
                icon: "error"
            })
        })
    }

    return (
        <div>
            <div className="layout-wrapper layout-content-navbar">
                <div className="layout-container">
                    <SideBar />
                    <div className="layout-page">
                        <Navbar />
                        <div className="content-wrapper">
                            <div className="container-xxl flex-grow-1 container-p-y">
                                <h4 className="fw-bold py-3 mb-4"><span className="text-muted fw-light">Dashboard /</span>Bannerlər</h4>
                                {
                                    loading ?
                                    <div className="d-flex justify-content-center align-items-center">
                                            <ClipLoader color={'#696cff'} loading={loading} size={150} />
                                        </div>
                                        :
                                <div className="row justify-content-center">
                                    <div className="col-md-12">
                                        <div className="card">
                                            <div className="card-header d-flex justify-content-between">
                                                <h5 className="">Bannerlər</h5>
                                                <Link to="/banner/create" className="btn btn-success">Yeni Banner əlave et</Link>
                                            </div>
                                            <div className="card-body">
                                                <table className="table">
                                                    <thead className="table-dark">
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Sayt</th>
                                                        <th>Yer</th>
                                                        <th>Status</th>
                                                        <th>Əməliyyatlar</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody className="table-border-bottom-0">
                                                    {
                                                        banners?.data?.data?.data ?
                                                            banners?.data?.data?.data.map((row, key) => (
                                                                <tr key={row.id}>
                                                                    <td><strong>{row.id}</strong></td>
                                                                    <td>{row?.site?.name}</td>
                                                                    <td><img height="150" width="250" src={row?.category?.image}
                                                                             alt=""/></td>
                                                                    <td>
                                                        <span className={`badge bg-${row.status ? 'info' : 'danger'}`}>
                                                            {row.status ? 'active' : 'deactive'}
                                                        </span>
                                                                    </td>
                                                                    <td>
                                                                        <Link to={`/banner/${row.id}/edit`}
                                                                              className="btn btn-primary me-2">
                                                                            <i class="fas fa-edit"></i>
                                                                        </Link>
                                                                        <Button variant="danger" onClick={() => deleteBanner(row.id)}>
                                                                            <i class="fa-solid fa-trash"></i>
                                                                        </Button>
                                                                    </td>
                                                                </tr>
                                                            )) :
                                                            <tr>
                                                                <td>Yuklenir...</td>
                                                            </tr>
                                                    }
                                                    </tbody>
                                                </table>
                                                <div className="card-footer bg-white">
                                                    <Pagination
                                                        activePage={banners?.data?.data?.meta?.current_page ?? 0}
                                                        itemsCountPerPage={banners?.data?.data?.meta?.per_page ?? 0}
                                                        totalItemsCount={banners?.data?.data?.meta?.total ?? 0}
                                                        onChange={(pageNumber) => {
                                                            getBannersData(pageNumber)
                                                        }}
                                                        pageRangeDisplayed={8}
                                                        itemClass="page-item"
                                                        linkClass="page-link"
                                                        firstPageText="İlk Səhife"
                                                        lastPageText="Son Səhife"
                                                    />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                }
                            </div>
                            <Footer />
                            <div className="content-backdrop fade"></div>
                        </div>
                    </div>
                </div>
                <div className="layout-overlay layout-menu-toggle"></div>
            </div>
        </div>
    );
}

export default BannerIndex;