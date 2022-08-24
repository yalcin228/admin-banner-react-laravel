import React, { useState } from 'react'
import Form from 'react-bootstrap/Form'
import Button from 'react-bootstrap/Button'
import Row from 'react-bootstrap/Row';
import Col from 'react-bootstrap/Col';
import Swal from 'sweetalert2';
import { useNavigate } from 'react-router-dom'
import SideBar from '../../components/SideBar';
import Navbar from '../../components/Navbar';
import Footer from '../../components/Footer';
import apiClient from '../../services/Api';


export default function SiteCreate() {
    const navigate = useNavigate();
    const token = JSON.parse(localStorage.getItem('authInfo'));
    
    const [name, setName] = useState("")
    const [status, setStatus] = useState()
    const [validationError,setValidationError] = useState({})

    const createSite = async (e) => {
        e.preventDefault();
    
        const formData = new FormData()
    
        formData.append('name', name)
        formData.append('status', status)

        if (localStorage.getItem('loggedIn')) {
            await apiClient.post(`/api/site`, formData,{
                'headers':{
                    "Authorization": `Bearer ${token.access_token}`
                }
            }).then(({data})=>{
            Swal.fire({
                icon:"success",
                text:data.message
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
                                    <h4 className="fw-bold py-3 mb-4"><a href="{}"><span className="text-muted fw-light">Adminlər /</span></a>Yeni Sayt</h4>
                                    <div className="row">
                                        <div className="col-md-12">
                                            <div className="card mb-4">
                                            <h5 className="card-header">Yeni Sayt</h5>
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
                                                <Form onSubmit={createSite}>
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
                                                                <Form.Select value={status}  onChange={(e) => setStatus(e.target.value)}>
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
