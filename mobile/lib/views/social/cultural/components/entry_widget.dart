import 'package:erasmus_helper/models/culture_entry.dart';
import 'package:erasmus_helper/services/culture_service.dart';
import 'package:flutter/material.dart';

class EntryWidget extends StatelessWidget {
  final CultureEntry entry;

  const EntryWidget({Key? key, required this.entry}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return Card(
      elevation: 4,
      color: Colors.white,
      shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(10)),
      child: Padding(
          padding: const EdgeInsets.all(20),
          child: Column(
              crossAxisAlignment: CrossAxisAlignment.stretch,
              children: <Widget>[
                Padding(
                  padding: const EdgeInsets.only(bottom: 20),
                  child: ClipRRect(
                    borderRadius: BorderRadius.circular(4),
                    child: FutureBuilder(
                      future: CultureService.getCultureEntryImage(entry.uid),
                      builder: (context, response) {
                        if (response.connectionState == ConnectionState.done) {
                          if (response.data != null) {
                            String url = response.data as String;
                            return Image.network(
                              url,
                              height: 150,
                              fit: BoxFit.fitWidth,
                            );
                          }
                        }
                        return Container();
                      },
                    ),
                  ),
                ),
                Row(
                  children: <Widget>[
                    Expanded(
                      flex: 3,
                      child: Column(
                        crossAxisAlignment: CrossAxisAlignment.start,
                        children: <Widget>[
                          Text(
                            entry.title,
                            style: const TextStyle(fontSize: 18),
                          ),
                          const SizedBox(
                            height: 15,
                          ),
                          Row(
                            children: <Widget>[
                              const Icon(
                                Icons.location_on,
                                color: Colors.red,
                              ),
                              const SizedBox(
                                width: 5,
                              ),
                              Text(
                                entry.location,
                                textAlign: TextAlign.left,
                              ),
                            ],
                          )
                        ],
                      ),
                    )
                  ],
                )
              ])),
    );
  }
}
