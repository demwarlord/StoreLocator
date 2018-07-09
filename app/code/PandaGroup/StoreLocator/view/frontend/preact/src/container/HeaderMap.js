import { h, Component } from 'preact';
import { connect } from 'mobx-preact';
import Map from '../component/Map';

import Directions from './Directions';
import Marker from '../component/Marker';

@connect(['stateStore'])
export default class HeaderMap extends Component {

    constructor() {
        super();
        this.markerClick = this.markerClick.bind(this);
    }

    markerClick(props) {
        this.props.stateStore.changeView('single');
        this.context.router.history.push(`/${props.id}`);
    }

    render() {
        return(
            <section style={{width: '100%', height: '400px', position: 'relative', overflow: 'hidden'}}>
            <Map className='google-maps-container'
                 style={{width: '100%', height: '400px', position: 'relative', color:'pink'}}
                 google={this.context.google}
                 zoom={this.props.stateStore.zoom}
                 initialCenter={this.props.stateStore.geoTotal}
                 scrollwheel={false}
                 clickableIcons={false}
                 center={this.props.stateStore.geoTotal}>
                    {this.props.stateStore.stores.map((store) => (
                        <Marker key={store.id}
                                id={store.id}
                                position={{lat: store.geo.lat, lng: store.geo.lng}}
                                icon={this.context.constants.pin}
                                onClick={this.markerClick}/>
                    ))}
                <Directions points={this.props.stateStore.waypoints}/>
            </Map>
            </section>
        );
    }
}
