import 'package:erasmus_helper/models/cultureEntry.dart';
import 'package:flutter/material.dart';
import 'package:provider/provider.dart';

class CultureContent extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    final entry = Provider.of<CultureEntry>(context);
    final screenWidth = MediaQuery.of(context).size.width;
    final screenHeight = MediaQuery.of(context).size.height;

    return SingleChildScrollView(
      child: Column(children: <Widget>[
        SizedBox(
          height: screenHeight * 0.5,
        ),
        Align(
          alignment: Alignment.centerLeft,
          child: Padding(
            padding: EdgeInsets.symmetric(horizontal: screenWidth * 0.1),
            child: Text(
              entry.title,
            ),
          ),
        ),
        SizedBox(
          height: 20,
        ),
        Padding(
          padding: EdgeInsets.symmetric(horizontal: screenWidth * 0.1),
          child: Row(
            children: <Widget>[
              Icon(
                Icons.location_on,
                color: Colors.blue,
              ),
              SizedBox(
                width: 5,
              ),
              Text(
                entry.location,
              ),
            ],
          ),
        )
      ]),
    );
  }
}
