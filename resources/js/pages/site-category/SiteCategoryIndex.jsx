import React, { useEffect, useState } from 'react'
import SideBar from "../../components/SideBar";
import Navbar from "../../components/Navbar";
import Footer from "../../components/Footer";
import Button from "react-bootstrap/Button";
import Pagination from "react-js-pagination";
import {Link} from "react-router-dom";
import apiClient from '../../services/Api';
import Swal from 'sweetalert2';
import ClipLoader from "react-spinners/ClipLoader";

export default function SiteCategoryIndex() {

    const token = JSON.parse(localStorage.getItem('authInfo'));

    const [siteCategory, setSiteCategory] = useState([]);
    const [loading,setLoading] = useState(false);

    useEffect(() => {
        setLoading(true);
        getSiteCategoryData();
    }, []);

    const getSiteCategoryData = async (pageNumber = 1) => {
        await apiClient.get(`/api/site-category?page=${pageNumber}`,{
            'headers':{
                "Authorization": `Bearer ${token.access_token}`
            }
        }).then((response) => {
            setLoading(false);
            setSiteCategory(response)
        });
    }

    const deleteSiteCategory = async (id) => {
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
          await apiClient.delete(`/api/site-category/${id}`,{
            'headers':{
                "Authorization": `Bearer ${token.access_token}`
            }
          }).then(({data})=>{
            Swal.fire({
                icon:"success",
                text:data.message
            })
            getSiteCategoryData()
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
                                    <h4 className="fw-bold py-3 mb-4"><span className="text-muted fw-light">Dashboard /</span>Sayt Kateqoriyaları </h4>
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
                                                    <h5 className="">Sayt Kateqoriyaları</h5>
                                                    <Link to="/site-category/create" className="btn btn-success">Yeni Sayt Kateqoriyası əlave et</Link>
                                                </div>
                                                <div className="card-body">
                                                    <table className="table">
                                                        <thead className="table-dark">
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>Sayt</th>
                                                            <th>Saytdakı Şəkil</th>
                                                            <th>Yer</th>
                                                            <th>Növ</th>
                                                            <th>Status</th>
                                                            <th>Əməliyyatlar</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody className="table-border-bottom-0">
                                                        {
                                                            siteCategory?.data?.data ?
                                                                siteCategory?.data?.data.map((row, key) => (
                                                                    <tr key={key}>
                                                                        <td><strong>{row.id}</strong></td>
                                                                        <td>{row.site_name}</td>
                                                                        <td>
                                                                            <img height="80" width="80" src={row?.image}
                                                                                alt=""/>
                                                                        </td>
                                                                        <td width={400}>{row?.place}</td>
                                                                        <td>{row.type}</td>
                                                                        <td>
                                                                            <span className={`badge bg-${row.status === "deactive" ? "danger" : "info"}`}>{row.status}</span>
                                                                        </td>
                                                                        <td>
                                                                            <Link to={`/site-category/${row.id}/edit`}
                                                                                className="btn btn-primary me-2">
                                                                                <i class="fas fa-edit"></i>
                                                                            </Link>
                                                                            <Button variant="danger" onClick={()=>deleteSiteCategory(row.id)} >
                                                                                <i class="fa-solid fa-trash"></i>
                                                                            </Button>
                                                                        </td>
                                                                    </tr>
                                                                )) :
                                                                <tr>
                                                                    <td>Yüklənir...</td>
                                                                </tr>
                                                        }
                                                        </tbody>
                                                    </table>
                                                    <div className="card-footer bg-white">
                                                        <Pagination
                                                            activePage={siteCategory?.data?.meta?.current_page ? siteCategory?.data?.meta?.current_page : 0}
                                                            itemsCountPerPage={siteCategory?.data?.meta?.per_page ? siteCategory?.data?.meta?.per_page : 0 }
                                                            totalItemsCount={siteCategory?.data?.meta?.total ? siteCategory?.data?.meta?.total : 0}
                                                            onChange={(pageNumber) => {
                                                                getSiteCategoryData(pageNumber)
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
