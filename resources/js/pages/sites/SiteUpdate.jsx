import React, { useEffect, useState } from 'react'
import Form from 'react-bootstrap/Form'
import Button from 'react-bootstrap/Button';
import Row from 'react-bootstrap/Row';
import Col from 'react-bootstrap/Col';
import { Link } from 'react-router-dom';
import Swal from 'sweetalert2';
import { useNavigate, useParams } from 'react-router-dom'
import SideBar from '../../components/SideBar';
import Navbar from '../../components/Navbar';
import Footer from '../../components/Footer';
import apiClient from '../../services/Api';

export default function SiteUpdate() {
    const navigate = useNavigate();
    const { id } = useParams();
    const token = JSON.parse(localStorage.getItem('authInfo'));

    const [name, setName] = useState("")
    const [status, setStatus] = useState()
    const [validationError,setValidationError] = useState({})

    useEffect(()=>{
        getByIdSite()
      },[])
     
    const getByIdSite = async () => {
        await apiClient.get(`/api/site/${id}`,{
            'headers':{
                "Authorization": `Bearer ${token.access_token}`
            }
        }).then(({data})=>{
            if (localStorage.getItem('loggedIn')) {
                const { name, status } = data.site
                setName(name)
                setStatus(status)
            }
        }).catch(({response:{data}})=>{
            Swal.fire({
            text:data.message,
            icon:"error"
            })
        })
    }

    const updateProduct = async (e) => {
        e.preventDefault();
    
        const formData = new FormData()
        formData.append('_method', 'PATCH');
        formData.append('name', name)
        formData.append('status', status)

        if (localStorage.getItem('loggedIn')) {
            await apiClient.post(`/api/site/${id}`, formData,{
                'headers':{
                    "Authorization": `Bearer ${token.access_token}`
                }
            }).then(({data})=>{
            Swal.fire({
                icon:"success",
                text:"Məlumatlar yeniləndi"
            })
            navigate("/sites")
            }).catch(({response})=>{
            if(response.status===422){
                setValidationError(response.data.errors)
            }else{
                Swal.fire({
                text:response.data.message,
                icon:"error"
                })
            }
            })
        }
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
                                        <h4 className="fw-bold py-3 mb-4"><Link to={"/"}><span className="text-muted fw-light">Adminlər /</span></Link>Sayt Redaktə</h4>
                                        <div className="row">
                                            <div className="col-md-12">
                                                <div className="card mb-4">
                                                <h5 className="card-header">Sayt Redaktə</h5>
                                                <div className="card-body">
                                                {
                                                    Object.keys(validationError).length > 0 && (
                                                        <div className='alert alert-danger'>
                                                            <ul className="mb-0">
                                                                {
                                                                    Object.entries(validationError).map(([key, value])=>(
                                                                        <li key={key}>{value}</li>   
                                                                    ))
                                                                }
                                                            </ul>
                                                        </div>
                                                    )
                                                }


                                                    <div>
                                                    <Form onSubmit={updateProduct}>
                                                        <Row> 
                                                            <Col>
                                                                <Form.Group controlId="Name">
                                                                    <Form.Label>Sayt Adı</Form.Label>
                                                                    <Form.Control type="text" value={name} onChange={(event)=>{
                                                                        setName(event.target.value)
                                                                    }}/>
                                                                </Form.Group>
                                                            </Col>  
                                                        </Row>
                                                        <Row className="my-3">
                                                            <Col>
                                                                <Form.Group controlId="Status">
                                                                    <Form.Label>Status</Form.Label>
                                                                    <Form.Select value={status} onChange={(e) => setStatus(e.target.value)}>
                                                                        <option>Seçin</option>
                                                                        <option value="1">Aktiv</option>
                                                                        <option value="0">Deaktiv</option>
                                                                    </Form.Select>
                                                                </Form.Group>
                                                            </Col>
                                                        </Row>
                                                        
                                                        <Button variant="primary" className="mt-2" size="lg" block="block" type="submit">
                                                            Əlave et
                                                        </Button>
                                                    </Form>
                                                    </div>
                                                </div>
                                                </div>
                                            </div>
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

