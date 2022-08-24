import React, {useEffect, useState} from 'react';
import Form from "react-bootstrap/Form";
import Row from "react-bootstrap/Row";
import Col from "react-bootstrap/Col";
import SideBar from '../../components/SideBar';
import Navbar from '../../components/Navbar';
import Footer from '../../components/Footer';
import Button from "react-bootstrap/Button";
import Swal from "sweetalert2";
import {useNavigate} from "react-router-dom";
import defaultImage from './default-image.jpg';
import apiClient from '../../services/Api';

function BannerCreate() {

    const navigate = useNavigate();
    const token = JSON.parse(localStorage.getItem('authInfo'));

    const [ads, setAds] = useState('');
    const [sites, setSites] = useState([]);
    const [places, setPlaces] = useState(0);
    const [status, setStatus] = useState();
    const [validationError, setValidationError] = useState({});
    const [selectedSites, setSelectedSites] = useState('');
    const [selectedPlaces, setSelectedPlaces] = useState('');


    useEffect(() => {
        getSitesList();
    }, []);

    const getSitesList = async () => {
        await apiClient.get(`/api/sites-without-paginate`,{
            'headers':{
                "Authorization": `Bearer ${token.access_token}`
            }
        }).then((data) => {
            const sites = data.data;
            setSites({sites});
        })
    }

    const getCategoryBySiteId = async (id) => {
        setSelectedSites(id);

        await apiClient.get(`/api/banner-places/${id}`,{
            'headers':{
                "Authorization": `Bearer ${token.access_token}`
            }
        }).then((res) => {
            setPlaces({res});
        })
    }

    const getImageByCategoryId = async (e) => {
        setSelectedPlaces(e.target.value);

        let id = e.target.value;

        await apiClient.get(`/api/image/${id}`,{
            'headers':{
                "Authorization": `Bearer ${token.access_token}`
            }
        }).then((res)=>{
            document.getElementById('image').src = 'http://localhost:8000/storage/site-category/' + res.data.data;
        })
    }

    const createBanner = async (e) => {
        e.preventDefault();

        const formData = new FormData();

        formData.append('ads', ads);
        formData.append('site_id', selectedSites);
        formData.append('category_id', selectedPlaces);
        formData.append('status', status);

        await apiClient.post(`/api/banner`, formData,{
            'headers':{
                "Authorization": `Bearer ${token.access_token}`
            }
        }).then(({data}) => {
            Swal.fire({
                icon: data.icon,
                text: data.message
            })
            navigate("/banners")
        }).catch(({response}) => {
            if (response.status === 422) {
                setValidationError(response.data.errors)
            } else {
                Swal.fire({
                    text: response.data.message,
                    icon: "error"
                })
            }
        })

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
                                <h4 className="fw-bold py-3 mb-4"><a href=""><span
                                    className="text-muted fw-light">Bannerlər /</span></a>Yeni Banner</h4>
                                <div className="row">
                                    <div className="col-md-12">
                                        <div className="card mb-4">
                                            <h5 className="card-header">Yeni Banner</h5>
                                            <div className="card-body">
                                                {
                                                    Object.keys(validationError).length > 0 && (
                                                        <div className='alert alert-danger'>
                                                            <ul className="mb-0">
                                                                {
                                                                    Object.entries(validationError).map(([key, value]) => (
                                                                        <li key={key}>{value}</li>
                                                                    ))
                                                                }
                                                            </ul>
                                                        </div>
                                                    )
                                                }
                                                <div>
                                                    <Form onSubmit={createBanner}>
                                                        <Row className="my-3">
                                                            <Col>
                                                                <Form.Group controlId="ads">
                                                                    <Form.Label>Reklam</Form.Label>
                                                                    <Form.Control type="text" value={ads}
                                                                                  onChange={(e) => setAds(e.target.value)}/>
                                                                </Form.Group>
                                                            </Col>
                                                        </Row>
                                                        <Row className="my-3">
                                                            <Col>
                                                                <Form.Group controlId="sites">
                                                                    <Form.Label>Sayt Adı</Form.Label>
                                                                    <Form.Select value={selectedSites}
                                                                                 onChange={(e) => getCategoryBySiteId(e.target.value)}>

                                                                        <option>Secin</option>
                                                                        {
                                                                            sites?.sites ?
                                                                                sites?.sites?.data.map((site, key) => (
                                                                                    <option key={key}
                                                                                            value={site.id}>{site.name}</option>
                                                                                )) : ''
                                                                        }

                                                                    </Form.Select>
                                                                </Form.Group>
                                                            </Col>
                                                        </Row>
                                                        <Row className="my-3">
                                                            <Col>
                                                                <Form.Group controlId="places">
                                                                    <Form.Label>Kategoriyalar</Form.Label>
                                                                    <Form.Select value={selectedPlaces}
                                                                                 onChange={(e) => getImageByCategoryId(e)}>
                                                                        <option>Seçin</option>
                                                                        {
                                                                            places.res?.data?.data ?
                                                                                places.res?.data?.data.map((place, key) => (
                                                                                    <option key={key}
                                                                                            value={place.id}>{place.place}</option>
                                                                                )) : ''
                                                                        }
                                                                    </Form.Select>
                                                                </Form.Group>
                                                            </Col>
                                                        </Row>
                                                        <Row className="my-3">
                                                            <Col>
                                                                <Form.Group controlId="places">
                                                                    <Form.Label>Yerin şəkili</Form.Label>
                                                                    <br/>
                                                                    <img height="500" width="450" src={defaultImage} id="image" alt=""/>
                                                                </Form.Group>
                                                            </Col>
                                                        </Row>
                                                        <Row className="my-3">
                                                            <Col>
                                                                <Form.Group controlId="status">
                                                                    <Form.Label>Status</Form.Label>
                                                                    <Form.Select value={status}
                                                                                 onChange={(e) => setStatus(e.target.value)}>
                                                                        <option>Seçin</option>
                                                                        <option value="1">Active</option>
                                                                        <option value="0">Deactive</option>
                                                                    </Form.Select>
                                                                </Form.Group>
                                                            </Col>
                                                        </Row>

                                                        <Button variant="primary" className="mt-2" size="lg"
                                                                block="block" type="submit">
                                                            Əlave et
                                                        </Button>
                                                    </Form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <Footer/>
                            <div className="content-backdrop fade"></div>
                        </div>
                    </div>
                </div>
                <div className="layout-overlay layout-menu-toggle"></div>
            </div>
        </div>
    );
}

export default BannerCreate;