import React, {useEffect, useState} from 'react';
import apiClient from "../../services/Api";
import SideBar from "../../components/SideBar";
import Navbar from "../../components/Navbar";
import Footer from "../../components/Footer";
import dateFormat, {masks} from "dateformat";
import Pagination from "react-js-pagination";
import ClipLoader from "react-spinners/ClipLoader";
import Flatpickr from "react-flatpickr";
import "flatpickr/dist/themes/material_green.css";

function LogIndex() {
    const token = JSON.parse(localStorage.getItem('authInfo'));
    const [loading, setLoading] = useState(false);
    const [logs, setLogs] = useState([]);
    const [id, setId] = useState();
    const [info, setInfo] = useState();
    const [user, setUser] = useState([]);
    const [ip, setIp] = useState();
    const [date, setDate] = useState("");
    const [username, setUsername] = useState('');

    useEffect(() => {
        setLoading(true);
        getLogList();
        getSelectBoxUserList();
    }, []);

    const getLogList = async (pageNumber = 1) => {
        await apiClient.get(`/api/log?page=${pageNumber}`,{
            'headers':{
                "Authorization": `Bearer ${token.access_token}`
            }
        }).then((res) => {
            setLoading(false);
            setLogs(res)
        })
    }

    const getSelectBoxUserList = async () => {
        await apiClient.get(`/api/admins-without-paginate`,{
            'headers':{
                "Authorization": `Bearer ${token.access_token}`
            }
        }).then((res) => {
            setUser(res)
        })
    }

    const handleSubmit = async (event) => {
        event.preventDefault();

        const formData = new FormData();

         id && formData.append('id', id);
         username && formData.append('admin', username);
         info && formData.append('info', info);
         ip && formData.append('ip', ip);
         date && formData.append('date', date);
        await apiClient.post(`/api/search`, formData,{
            'headers':{
                "Authorization": `Bearer ${token.access_token}`
            }
        }).then((res) => {
            setLoading(false);
            setLogs(res);
        })
    }

    function formatDate(date) {
        if(date){
            var d = new Date(date),
            month = '' + (d.getMonth() + 1),
            day = '' + d.getDate(),
            year = d.getFullYear();
    
            if (month.length < 2) 
                month = '0' + month;
            if (day.length < 2) 
                day = '0' + day;
        
            setDate([year, month, day].join('-'));
        }else{
            setDate("");
        }
        
    }

    return (
        <div>
            <div className="layout-wrapper layout-content-navbar">
                <div className="layout-container">
                    <SideBar/>
                    <div className="layout-page">
                        <Navbar/>
                        <div className="content-wrapper">
                            <div className="container-xxl flex-grow-1 container-p-y">
                                <h4 className="fw-bold py-3 mb-4"><span
                                    className="text-muted fw-light">Dashboard /</span>Loglar</h4>
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
                                                    <h5 className="">Loglar</h5>
                                                </div>
                                                <div className="card-body">

                                                    <form onSubmit={handleSubmit}>
                                                        <div className="row">
                                                        <div className="col-md-2">
                                                            <label htmlFor="id">ID</label>
                                                            <input type="text" className="form-control col-md-2"
                                                                    placeholder="ID"
                                                                    name="id" value={id} onChange={(e) => {
                                                                setId(e.target.value)
                                                            }}/>
                                                        </div>
                                                            <div className="col-md-2">
                                                                <label htmlFor="users">Username</label>
                                                                <select className="form-select" id="users" name="users" value={username}
                                                                onChange={(e)=>{
                                                                    setUsername(e.target.value)
                                                                }}>
                                                                    <option>Seçin</option>
                                                                    {
                                                                        user.data?.data ?
                                                                            user.data?.data.map((row, key) => (
                                                                                <option key={key}
                                                                                        value={row.id}>{row.username}</option>
                                                                            ))
                                                                            :
                                                                            ''
                                                                    }
                                                                </select>
                                                            </div>
                                                            <div className="col-md-2">
                                                                <label htmlFor="info">info</label>
                                                                <input type="text" className="form-control"
                                                                    placeholder="info" id="info"
                                                                    name="info" value={info}
                                                                    onChange={(e) => {
                                                                        setInfo(e.target.value)
                                                                    }}/>
                                                            </div>
                                                            <div className="col-md-2">
                                                                <label htmlFor="ip">IP</label>
                                                                <input type="text" value={ip} className="form-control"
                                                                    placeholder="ip" name="ip"
                                                                    onChange={(event => setIp(event.target.value))}/>
                                                            </div>
                                                            <div className="col-md-2">
                                                                <label htmlFor="dateTimeFlatpickr">Zaman</label>
                                                                {/* <div className="form-group mb-0">
                                                                    <input id="dateTimeFlatpickr" name="date"
                                                                        value={date} onChange={(e) => {
                                                                        setDate(e.target.value)
                                                                    }}
                                                                        className="form-control flatpickr flatpickr-input"
                                                                        type="date"
                                                                        placeholder="Vaxtı Seç.."/>
                                                                </div> */}
                                                                    <Flatpickr
                                                                        data-enable-time
                                                                        value={date} onChange={(e) => {
                                                                            formatDate(e[0])
                                                                        }}
                                                                    />
                                                            </div>
                                                            <div className="col-md-2">
                                                                <label htmlFor="search">Axtar</label><br/>
                                                                <button className="btn btn-warning btn-block" id="search">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                        height="24"
                                                                        viewBox="0 0 24 24"
                                                                        fill="none" stroke="currentColor"
                                                                        strokeWidth="2"
                                                                        strokeLinecap="round"
                                                                        strokeLinejoin="round"
                                                                        className="feather feather-search text-center">
                                                                        <circle cx="11" cy="11" r="8"></circle>
                                                                        <line x1="21" y1="21" x2="16.65"
                                                                            y2="16.65"></line>
                                                                    </svg>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </form>

                                                    <br/>

                                                    <table className="table table-bordered table-striped">
                                                        <thead>
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>İSTIFADƏÇI ADI</th>
                                                            <th>INFO</th>
                                                            <th>ƏMƏLIYYAT</th>
                                                            <th>MODUL</th>
                                                            <th>IP</th>
                                                            <th>TARIX</th>
                                                            <th>ƏMƏLIYYATLAR</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        {
                                                            logs?.data?.data?.data ?
                                                                logs?.data?.data?.data?.map((row, key) => (

                                                                    <tr key={row.id}>
                                                                        <td><strong>{row.id}</strong></td>
                                                                        <td>{row.user.username}</td>
                                                                        <td>{row.info}</td>
                                                                        <td>{row.action}</td>
                                                                        <td>{row.module}</td>
                                                                        <td>{row.ip}</td>
                                                                        <td>{dateFormat(row.created_at, 'mm/dd/yyyy | HH:MM')}</td>
                                                                    </tr>

                                                                ))

                                                                : <tr>
                                                                    <td>Yuklenir...</td>
                                                                </tr>
                                                        }
                                                        </tbody>
                                                    </table>

                                                    <div className="card-footer bg-white">
                                                        <Pagination
                                                            activePage={logs?.data?.data?.meta?.current_page ?? 0}
                                                            itemsCountPerPage={logs?.data?.data?.meta?.per_page ?? 0}
                                                            totalItemsCount={logs?.data?.data?.meta?.total ?? 0}
                                                            onChange={(pageNumber) => {
                                                                getLogList(pageNumber)
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
                                {/* <div className="row justify-content-center">
                                    <div className="col-md-12">
                                        <div className="card">
                                            <div className="card-header d-flex justify-content-between">
                                                <h5 className="">Loglar</h5>
                                            </div>
                                            <div className="card-body">

                                                <form onSubmit={handleSubmit}>
                                                    <div className="row">
                                                       <div className="col-md-2">
                                                           <label htmlFor="id">ID</label>
                                                           <input type="text" className="form-control col-md-2"
                                                                  placeholder="ID"
                                                                  name="id" value={id} onChange={(e) => {
                                                               setId(e.target.value)
                                                           }}/>
                                                       </div>
                                                        <div className="col-md-2">
                                                            <label htmlFor="users">Username</label>
                                                            <select className="form-select" id="users" name="users" value={username}
                                                            onChange={(e)=>{
                                                                setUsername(e.target.value)
                                                            }}>
                                                                <option>Seçin</option>
                                                                {
                                                                    user.data?.data ?
                                                                        user.data?.data.map((row, key) => (
                                                                            <option key={key}
                                                                                    value={row.id}>{row.username}</option>
                                                                        ))
                                                                        :
                                                                        ''
                                                                }
                                                            </select>
                                                        </div>
                                                        <div className="col-md-2">
                                                            <label htmlFor="info">info</label>
                                                            <input type="text" className="form-control"
                                                                   placeholder="info" id="info"
                                                                   name="info" value={info}
                                                                   onChange={(e) => {
                                                                       setInfo(e.target.value)
                                                                   }}/>
                                                        </div>
                                                        <div className="col-md-2">
                                                            <label htmlFor="ip">IP</label>
                                                            <input type="text" value={ip} className="form-control"
                                                                   placeholder="ip" name="ip"
                                                                   onChange={(event => setIp(event.target.value))}/>
                                                        </div>
                                                        <div className="col-md-2">
                                                            <label htmlFor="dateTimeFlatpickr">Zaman</label>
                                                            <div className="form-group mb-0">
                                                                <input id="dateTimeFlatpickr" name="date"
                                                                       value={date} onChange={(e) => {
                                                                    setDate(e.target.value)
                                                                }}
                                                                       className="form-control flatpickr flatpickr-input"
                                                                       type="date"
                                                                       placeholder="Vaxtı Seç.."/>
                                                            </div>
                                                        </div>
                                                        <div className="col-md-2">
                                                            <label htmlFor="search">Axtar</label><br/>
                                                            <button className="btn btn-warning btn-block" id="search">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                     height="24"
                                                                     viewBox="0 0 24 24"
                                                                     fill="none" stroke="currentColor"
                                                                     strokeWidth="2"
                                                                     strokeLinecap="round"
                                                                     strokeLinejoin="round"
                                                                     className="feather feather-search text-center">
                                                                    <circle cx="11" cy="11" r="8"></circle>
                                                                    <line x1="21" y1="21" x2="16.65"
                                                                          y2="16.65"></line>
                                                                </svg>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>

                                                <br/>

                                                <table className="table table-bordered table-striped">
                                                    <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>İSTIFADƏÇI ADI</th>
                                                        <th>INFO</th>
                                                        <th>ƏMƏLIYYAT</th>
                                                        <th>MODUL</th>
                                                        <th>IP</th>
                                                        <th>TARIX</th>
                                                        <th>ƏMƏLIYYATLAR</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    {
                                                        logs?.data?.data?.data ?
                                                            logs?.data?.data?.data?.map((row, key) => (

                                                                <tr key={row.id}>
                                                                    <td><strong>{row.id}</strong></td>
                                                                    <td>{row.user.username}</td>
                                                                    <td>{row.info}</td>
                                                                    <td>{row.action}</td>
                                                                    <td>{row.module}</td>
                                                                    <td>{row.ip}</td>
                                                                    <td>{dateFormat(row.created_at, 'mm/dd/yyyy | HH:MM')}</td>
                                                                </tr>

                                                            ))

                                                            : <tr>
                                                                <td>Yuklenir...</td>
                                                            </tr>
                                                    }
                                                    </tbody>
                                                </table>

                                                <div className="card-footer bg-white">
                                                    <Pagination
                                                        activePage={logs?.data?.data?.meta?.current_page ?? 0}
                                                        itemsCountPerPage={logs?.data?.data?.meta?.per_page ?? 0}
                                                        totalItemsCount={logs?.data?.data?.meta?.total ?? 0}
                                                        onChange={(pageNumber) => {
                                                            getLogList(pageNumber)
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
                                </div> */}
                            </div>
                            <Footer/>
                            <div className="content-backdrop fade"></div>
                        </div>
                    </div>
                </div>
                <div className="layout-overlay layout-menu-toggle"></div>
            </div>

        </div>
    )
}

export default LogIndex;