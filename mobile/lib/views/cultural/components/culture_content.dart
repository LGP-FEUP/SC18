import 'package:erasmus_helper/models/culture_entry.dart';
import 'package:flutter/material.dart';
import 'package:provider/provider.dart';

class CultureContent extends StatelessWidget {
  const CultureContent({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    final entry = Provider.of<CultureEntry>(context);
    final screenWidth = MediaQuery.of(context).size.width;
    final screenHeight = MediaQuery.of(context).size.height;

    return SingleChildScrollView(
      child: Column(children: <Widget>[
        SizedBox(
          height: screenHeight * 0.48,
        ),
        Align(
          alignment: Alignment.centerLeft,
          child: Padding(
            padding: EdgeInsets.symmetric(horizontal: screenWidth * 0.05),
            child: Text(
              entry.title,
            ),
          ),
        ),
        const SizedBox(
          height: 10,
        ),
        Padding(
          padding: EdgeInsets.symmetric(horizontal: screenWidth * 0.05),
          child: Row(
            children: <Widget>[
              const Icon(
                Icons.location_on,
                color: Colors.blue,
              ),
              const SizedBox(
                width: 5,
              ),
              Text(
                entry.location,
              ),
            ],
          ),
        ),
        const SizedBox(
          height: 10,
        ),
        Padding(
          padding: EdgeInsets.symmetric(horizontal: screenWidth * 0.1),
          child: SizedBox(
            height: 190,
            child: SingleChildScrollView(
              scrollDirection: Axis.vertical,
              child: Column(children: <Widget>[
                Text(entry.description),
              ]),
            ),
          ),
        ),
      ]),
    );
  }
}
