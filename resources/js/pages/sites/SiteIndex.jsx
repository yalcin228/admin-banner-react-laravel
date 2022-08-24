import React, { useEffect, useState } from 'react'
import {Link} from "react-router-dom";
import Pagination from "react-js-pagination";
import Button from 'react-bootstrap/Button';
import Swal from 'sweetalert2';
import SideBar from '../../components/SideBar';
import Navbar from '../../components/Navbar';
import Footer from '../../components/Footer';
import apiClient from '../../services/Api';
import ClipLoader from "react-spinners/ClipLoader";


export default function SiteIndex() {
    
    const [sites, setSites] = useState([]);
    const token = JSON.parse(localStorage.getItem('authInfo'));
    const [loading,setLoading] = useState(false);

    useEffect(() => {
        setLoading(true);
        getSitesData()
    }, []);


    //fetch sites
    const getSitesData = async (pageNumber = 1) => {
        if (localStorage.getItem('loggedIn')) {
            const api = await fetch(`http://127.0.0.1:8000/api/site?page=${pageNumber}`, {
                'headers':{
                    "Authorization": `Bearer ${token.access_token}`
                }
            });
            setLoading(false);
            setSites({
                sites: await api.json()
            });
        }
    }
    
    //delete site
    const deleteSite = async (id) => {
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

          if(!isConfirm){
            return;
          }
          await apiClient.delete(`/api/site/${id}`).then(({data})=>{
            Swal.fire({
                icon:"success",
                text:data.message
            })
            getSitesData()
          }).catch(({response:{data}})=>{
            Swal.fire({
                text:data.message,
                icon:"error"
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
                                    <h4 className="fw-bold py-3 mb-4"><span className="text-muted fw-light">Dashboard /</span>Saytlar</h4>
                                    
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
                                                    <h5 className="">Saytlar</h5>
                                                    <Link to="/site/create" className="btn btn-success">Yeni Sayt əlave et</Link>
                                                    </div>
                                                        <div className="card-body">
                                                            <table className="table">
                                                                <thead className="table-dark">
                                                                    <tr>
                                                                        <th>ID</th>
                                                                        <th>Ad</th>
                                                                        <th>Status</th>
                                                                        <th>Əməliyyatlar</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody className="table-border-bottom-0">
                                                                {   
                                                                    sites?.sites?.data?.data ? 
                                                                        sites?.sites?.data?.data?.map((row, key) => (
                                                                            <tr key={row.id}>
                                                                                <td><strong>{row.id}</strong></td>
                                                                                <td>{row.name}</td>
                                                                                <td>
                                                                                    <span className={`badge bg-${row.status === 0 ? "danger" : "info"}`}>{row.status === 0 ? 'deactive' : 'active'}</span>
                                                                                </td>
                                                                                <td>
                                                                                    <Link to={`/site/${row.id}/edit`} className='btn btn-primary me-2'>
                                                                                        <i class="fas fa-edit"></i>
                                                                                    </Link>
                                                                                    <Button variant="danger" onClick={()=>deleteSite(row.id)}>
                                                                                        <i class="fa-solid fa-trash"></i>
                                                                                    </Button>
                                                                                </td>
                                                                            </tr>
                                                                        )) : <tr>
                                                                                <td>Yuklenir...</td>
                                                                            </tr>
                                                                }
                                                                    {/* {
                                                                        sites?.sites?.data?.data.length > 0 && (
                                                                            sites?.sites.data.data.map((row, key)=>(
                                                                                <tr key={key}>
                                                                                    <td><strong>{row.id}</strong></td>
                                                                                    <td>{row.name}</td>
                                                                                    <td>
                                                                                        <span className={`badge bg-${row.status === 0 ? "danger" : "info"}`}>{row.status === 0 ? 'deactive' : 'active'}</span>
                                                                                    </td>
                                                                                    <td>
                                                                                        <Link to="/sites" className="btn btn-xs btn-small btn-primary p-2"><i className="bx bx-edit-alt me-1"></i></Link>
                                                                                        <Link to="/sites" className="js-delete-admin btn btn-xs btn-danger p-2 m-1"> <i className="bx bx-trash me-1"></i></Link>
                                                                                    </td>
                                                                                </tr>
                                                                            ))
                                                                        )
                                                                    } */}
                                                                </tbody>
                                                            </table>
                                                            <div className="card-footer bg-white">
                                                                <Pagination
                                                                    activePage={sites?.sites?.data?.meta?.current_page ? sites?.sites?.data?.meta?.current_page : 0}
                                                                    itemsCountPerPage={sites?.sites?.data?.meta?.per_page ? sites?.sites?.data?.meta?.per_page : 0 }
                                                                    totalItemsCount={sites?.sites?.data?.meta?.total ? sites?.sites?.data?.meta?.total : 0}
                                                                    onChange={(pageNumber) => {
                                                                        getSitesData(pageNumber)
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
    )
}
