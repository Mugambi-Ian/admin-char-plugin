import React from 'react';
import { translate } from "../utils"


const Empty = () => (<div style={{ display: "flex", width: "100%", justifyContent: 'center', alignItems: 'center', height: "300px" }}>
  <h3> {translate("Add Records in the settings page")}</h3>
</div>)

export default Empty;