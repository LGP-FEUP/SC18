import 'package:erasmus_helper/models/cultureCategory.dart';
import 'package:erasmus_helper/views/cultural/components/categoryWidget.dart';
import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';

class CulturalPage extends StatelessWidget {
  const CulturalPage({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: Stack(
        children: <Widget>[
          SingleChildScrollView(
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: <Widget>[
                /*Padding(
                    padding: const EdgeInsets.symmetric(horizontal: 32.0),
                    child: Row(
                      children: <Widget>[
                        Text("BOOOOOOOAS"),
                        Spacer(),
                        Icon(Icons.person_outline),
                      ],
                    )),
                Padding(
                  padding: const EdgeInsets.all(8.0),
                  child: Text("HELLLOOOOOOOOOOOO"),
                ),*/
                SingleChildScrollView(
                  scrollDirection: Axis.horizontal,
                  child: Row(
                    children: <Widget>[
                      for (final category in cultureCategories)
                        CategoryWidget(category: category)
                    ],
                  ),
                )
              ],
            ),
          ),
        ],
      ),
    );
  }
}
