import React, { useEffect, useState } from 'react'
import {Link} from "react-router-dom";
import Button from 'react-bootstrap/Button';
import Pagination from "react-js-pagination";
import Swal from 'sweetalert2';
import SideBar from '../../components/SideBar';
import Navbar from '../../components/Navbar';
import Footer from '../../components/Footer';
import apiClient from '../../services/Api';
import ClipLoader from "react-spinners/ClipLoader";

export default function AdminIndex() {
    const [admins, setAdmins] = useState([]);
    const token = JSON.parse(localStorage.getItem('authInfo'));
    const [loading,setLoading] = useState(false);
    
    useEffect(() => {
        setLoading(true);
        getAdminsData()
    }, []);
    
        const getAdminsData = async (pageNumber = 1) => {
            if (localStorage.getItem('loggedIn')) {
                await apiClient.get(`/api/admin?page=${pageNumber}`,{
                    'headers':{
                        "Authorization": `Bearer ${token.access_token}`
                    }
                }).then(({data})=>{
                    setLoading(false);
                        setAdmins(data);
                })
            }
        }
    


    const deleteAdmin = async (id) => {
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
          await apiClient.delete(`/api/admin/${id}`).then(({data})=>{
            Swal.fire({
                icon:"success",
                text:data.message
            })
            getAdminsData()
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
                            <h4 className="fw-bold py-3 mb-4"><span className="text-muted fw-light">Dashboard /</span>Adminlər</h4>

                            <div className="row justify-content-center">
                                {
                                    loading ? 
                                    <div className="d-flex justify-content-center align-items-center">
                                            <ClipLoader color={'#696cff'} loading={loading} size={150} />
                                        </div>
                                        :
                                <div className="col-md-12">
                                    <div className="card">
                                        <div className="card-header d-flex justify-content-between">
                                        <h5 className="">Adminlər</h5>
                                        <Link to="/admin/create" className="btn btn-success">Yeni Admin əlave et</Link>
                                        </div>
                                            <div className="card-body">
                                                <table className="table">
                                                    <thead className="table-dark">
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>Ad Soyad</th>
                                                            <th>İstifadəçi adı</th>
                                                            <th>Email</th>
                                                            <th>Mobil nömrə</th>
                                                            <th>Status</th>
                                                            <th>Əməliyyatlar</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody className="table-border-bottom-0">
                                                        {
                                                            admins?.data?.data ? 
                                                            admins?.data?.data?.map((row, key) => (
                                                                <tr key={row.id}>
                                                                    <td><strong>{row.id}</strong></td>
                                                                    <td>{row.name}</td>
                                                                    <td>{row.username}</td>
                                                                    <td>{row.email}</td>
                                                                    <td>{row.phone}</td>
                                                                    <td>
                                                                        <span className={`badge bg-${row.status === "deactive" ? "danger" : "info"}`}>{row.status}</span>
                                                                    </td>
                                                                    <td>
                                                                        <Link to={`/admin/${row.id}/edit`} className='btn btn-primary me-2'>
                                                                                <i class="fas fa-edit"></i>
                                                                                </Link>
                                                                        <Button variant="danger" onClick={()=>deleteAdmin(row.id)}>
                                                                            <i class="fa-solid fa-trash"></i>
                                                                        </Button>
                                                                    </td>
                                                                </tr>
                                                            )
                                                            ) : <tr>
                                                                    <td>Yuklenir...</td>
                                                                </tr>
                                                        }
                                                            
                                                        
                                                    
                                                    </tbody>
                                                </table>
                                                <div className="card-footer bg-white">
                                                    <Pagination
                                                        activePage={admins?.data?.meta?.current_page ? admins?.data?.meta?.current_page : 0}
                                                        itemsCountPerPage={admins?.data?.meta?.per_page ? admins?.data?.meta?.per_page : 0 }
                                                        totalItemsCount={admins?.data?.meta?.total ? admins?.data?.meta?.total : 0}
                                                        onChange={(pageNumber) => {
                                                            getAdminsData(pageNumber)
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
                                }
                            </div>
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
