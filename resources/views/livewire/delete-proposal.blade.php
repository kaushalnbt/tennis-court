
    {
        try {
            $query = Proposal::find($proposal->_id);
            // if ($query) {
            //     echo "deleted Successfully";
            // }
            if ($query) {
                Proposal::find($proposal->_id)->delete();
                return true;
            } else
                return false;
        } catch (Exception $e) {
            return false;
        }
    }